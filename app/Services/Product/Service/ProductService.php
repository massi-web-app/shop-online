<?php

namespace App\Services\Product\Service;

use App\Http\Requests\Product\ProductRequest;
use App\Repositories\Product\ProductRepository;
use App\Services\Uploader\Uploader;

class ProductService
{

    private Uploader $uploader;
    private ProductRepository $productRepository;

    public function __construct(Uploader $uploader, ProductRepository $productRepository)
    {

        $this->uploader = $uploader;
        $this->productRepository = $productRepository;
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
}
