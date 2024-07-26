<?php

namespace App\Services\ProductWarranty;

use App\Helper\Helper;
use App\Http\Requests\ProductWarranty\ProductWarrantyRequest;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductWarranty;
use App\Repositories\Product\ProductRepository;
use App\Repositories\ProductColor\ProductColorRepository;
use App\Repositories\ProductWarranty\ProductWarrantyRepository;
use App\Repositories\Warranty\WarrantyRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ProductWarrantyService
{
    private WarrantyRepository $warrantyRepository;
    private ProductColorRepository $productColorRepository;
    private ProductWarrantyRepository $productWarrantyRepository;
    private ProductRepository $productRepository;
    private ProductPriceService $productPriceService;
    public static int $paginate = 10;


    public function __construct(ProductWarrantyRepository $productWarrantyRepository,ProductColorRepository $productColorRepository,WarrantyRepository $warrantyRepository,ProductRepository $productRepository,ProductPriceService $productPriceService)
    {
        $this->warrantyRepository = $warrantyRepository;
        $this->productColorRepository = $productColorRepository;
        $this->productWarrantyRepository = $productWarrantyRepository;
        $this->productRepository = $productRepository;
        $this->productPriceService = $productPriceService;
    }

    public function listWarranties(): array
    {
        return $this->warrantyRepository->list()->orderBy('id', 'desc')->pluck('name', 'id')->toArray();
    }

    public function listProductColor(int $productId): Collection
    {
        return $this->productColorRepository->listProductColor($productId);
    }

    public function list(Request $request,int $productId): LengthAwarePaginator
    {
        $queryString = '?';
        $productWarranties = $this->productWarrantyRepository->list($productId);
        if ($request->get('trashed') == 'true') {
            $productWarranties = $productWarranties->onlyTrashed();
            $queryString = Helper::generateQueryString($queryString, 'trashed=true');
        }

        $productWarranties = $productWarranties->paginate(self::$paginate);
        $productWarranties->withPath($queryString);
        return $productWarranties;
    }

    public function save(ProductWarrantyRequest $productWarrantyRequest): Model|ProductColor
    {
        return $this->productWarrantyRepository->save($productWarrantyRequest->all());
    }

    public function check_product_price(array $condition): bool
    {
        $check_product_warranty_price = $this->productWarrantyRepository
            ->check_product_warranty_price($condition)->first();
        if ($check_product_warranty_price) {
            return false;
        }
        return true;

    }

    public function onlyTrashed(int $productId): int
    {
        return $this->productWarrantyRepository->trashed($productId)->count();
    }

    public function removeItems(Request $request)
    {
        $product=$this->productRepository->withTrashed($request->get('product_id'));
        $this->productWarrantyRepository->remove_items($request->get('product_warranties_id'),$product);

    }

    public function restoreItems(Request $request)
    {
        $product=$this->productRepository->withTrashed($request->get('product_id'));
        $this->productWarrantyRepository->restore_items($request->get('product_warranties_id'),$product);
    }

    public function check_has_product_warranty(ProductWarranty $productWarranty)
    {
        $this->productWarrantyRepository->check_has_product_warranty($productWarranty);
    }

    public function delete(int $productWarrantyId)
    {
        $productWarranty=$this->productWarrantyRepository->delete($productWarrantyId);
        if ($productWarranty){
            $product=$this->productRepository->find($productWarranty->product_id);
            $this->productPriceService->check_price_today($productWarranty);
            $this->productPriceService->update_product_price($product);
        }

    }

    public function restore(int $productWarrantyId)
    {
        $productWarranty=$this->productWarrantyRepository->restore($productWarrantyId);
        $product=$this->productRepository->find($productWarranty->product_id);
        $this->productPriceService->add_min_product_price($productWarranty);
        $this->productPriceService->update_product_price($product);
    }

    public function find(int $productWarrantyId)
    {
        return $this->productWarrantyRepository->find($productWarrantyId);
    }

    public function update(int $productWarrantyId, ProductWarrantyRequest $productWarrantyRequest, Model|Collection|Builder|array|null $product)
    {
        $productWarranty=$this->productWarrantyRepository->update($productWarrantyId,$productWarrantyRequest->all());
        $this->productPriceService->add_min_product_price($productWarranty);
        $this->productPriceService->update_product_price($product);
        return $productWarranty;
    }


}
