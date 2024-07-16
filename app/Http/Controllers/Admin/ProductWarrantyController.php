<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CustomController;
use App\Http\Requests\ProductWarranty\ProductWarrantyRequest;
use App\Repositories\Product\ProductRepository;
use App\Repositories\ProductColor\ProductColorRepository;
use App\Services\ProductWarranty\ProductWarrantyService;
use Illuminate\Http\Request;

class ProductWarrantyController extends CustomController
{
    protected $service;
    protected $title = 'تنوع قیمت';
    protected $route_params = 'product_warranties';
    protected $product;
    protected $queryString;
    private ProductWarrantyService $productWarrantyService;
    private ProductColorRepository $productColorRepository;

    public function __construct(Request $request, ProductWarrantyService $productWarrantyService, ProductRepository $productRepository, ProductColorRepository $productColorRepository)
    {
        $product_id = (int)$request->get('product_id');
        $this->product = $productRepository->find($product_id);
        $this->service = $productWarrantyService;
        $this->queryString = 'product_id=' . $product_id;
        $this->productWarrantyService = $productWarrantyService;
    }

    public function create()
    {
        $warranties = $this->productWarrantyService->listWarranties();
        $product_colors = $this->productWarrantyService->listProductColor($this->product->id);

        return view('product_warranty.create', [
            'warranties' => $warranties,
            'product_colors' => $product_colors,
            'product' => $this->product
        ]);

    }

    public function store(ProductWarrantyRequest $productWarrantyRequest)
    {
        $this->productWarrantyService->save($productWarrantyRequest);

    }
}
