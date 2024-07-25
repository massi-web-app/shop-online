<?php

namespace App\Services\Product\Service;

use App\Helper\Helper;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use App\Services\Uploader\Uploader;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ProductService
{

    private Uploader $uploader;
    private ProductRepository $productRepository;
    public static int $paginate = 10;


    public function __construct(Uploader $uploader, ProductRepository $productRepository)
    {

        $this->uploader = $uploader;
        $this->productRepository = $productRepository;
    }

    public function list(Request $request)
    {
        $queryString = '?';
        $products = $this->productRepository->list();
        if (Helper::isTrashed($request)) {
            $products = $products->onlyTrashed();
            $queryString = Helper::generateQueryString($queryString, 'trashed=true');
        }

        if (Helper::hasStringInSearch($request)) {
            $products = $products->where('title', 'like', '%' . $request->get('string') . '%');
            $products = $products->orWhere('ename', 'like', '%' . $request->get('string') . '%');
            $queryString = Helper::generateQueryString($queryString, 'string=' . $request->get('string'));
        }

        $products = $products->paginate(self::$paginate);
        $products->withPath($queryString);
        return $products;

    }

    public function getStatusProduct(): array
    {
        return $this->productRepository->getStatus();
    }

    public function store(ProductRequest $request)
    {
        try {
            $data = $request->all();
            $image = $this->uploader->upload($request->file('image_url'), 'files/products');
            if (!empty($image)) {
                $data['image_url'] = $image;
                //todo:resolve thumbnails
            }
            $product =$this->productRepository->store($data);
            $this->productRepository->updateProductColors($product,$request->get('product_color_id'));
            return $product;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function countTrashed(): int
    {
        return $this->productRepository->trashed()->count();
    }

    public function listStatus()
    {
        return $this->productRepository->getStatus();
    }

    public function find(int $productId)
    {
        return $this->productRepository->find($productId);
    }

    public function update(ProductRequest $request, int $productId)
    {
        $product=$this->find($productId);
        $image_url = $this->uploader->upload($request->file('image_url'), 'files/products');
        if (!empty($image_url)) {
            $this->uploader->removeFile('files/products', $product->image_url);
            $product->image_url = $image_url;
            $product->save();
        }
        $this->productRepository->update($product,$request->except(['image_url']));
        $this->productRepository->updateProductColors($product,$request->get('product_color_id'));
        return $product;
    }

    public function delete(int $productId)
    {
       return $this->productRepository->delete($productId);
    }

    public function restore(int $productId)
    {
        $this->productRepository->restore($productId);
    }

    public function removeItems($request){
        $this->productRepository->remove_items($request->get('product_id'));
    }

    public function restoreItems($request)
    {
        $this->productRepository->restore_items($request->get('product_id'));
    }


}
