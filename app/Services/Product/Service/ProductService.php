<?php

namespace App\Services\Product\Service;

use App\Helper\Helper;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use App\Services\Uploader\Uploader;
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
//            Helper::fit_image('files/products/'.$image,$image);
            }

            $this->productRepository->store($data);
            return true;
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
        return Product::query()->findOrFail($productId);
    }

}
