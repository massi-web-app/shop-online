<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CustomController;
use App\Http\Requests\ProductWarranty\ProductWarrantyRequest;
use App\Repositories\Product\ProductRepository;
use App\Services\Product\Service\ProductService;
use App\Services\ProductWarranty\ProductPriceService;
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
    private ProductService $productService;
    private ProductPriceService $productPriceService;

    public function __construct(Request $request, ProductWarrantyService $productWarrantyService, ProductService $productService, ProductPriceService $productPriceService)
    {

        $product_id = (int)$request->get('product_id');
        $this->product = $productService->find($product_id);
        $this->service = $productWarrantyService;
        $this->productWarrantyService = $productWarrantyService;
        $this->productService = $productService;
        $this->productPriceService = $productPriceService;
        $this->queryString = ['params'=>'product_id','value'=>$this->product->id];
    }

    public function index(Request $request)
    {
        $productWarranties = $this->productWarrantyService->list($request, $this->product->id);
        $trashed_product_warranties = $this->productWarrantyService->onlyTrashed($this->product->id);
        return view('product_warranty.index', [
            'productWarranties' => $productWarranties,
            'trashed_product_warranties' => $trashed_product_warranties,
            'product' => $this->product,
            'request' => $request
        ]);
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
        $check_product_price = $this->productWarrantyService->check_product_price([
            'seller_id' => null,
            'warranty_id' => $productWarrantyRequest->get('warranty_id'),
            'color_id' => $productWarrantyRequest->get('color_id'),
            'product_id' => $this->product->id
        ]);
        if ($check_product_price) {
            $productWarranty = $this->productWarrantyService->save($productWarrantyRequest);
            $this->productPriceService->add_min_product_price($productWarranty);
            $this->productPriceService->update_product_price($this->product);
            return redirect()->route('product_warranties.index', 'product_id=' . $this->product->id)
                ->with('message', 'ثبت تنوع قیمت با موفقیت انجام شد');
        }
        return redirect()->route('product_warranties.create', 'product_id=' . $this->product->id)
            ->withInput()
            ->with('warning', 'این تنوع قیمت با این مشخصات از قبل ثبت شده است.');

    }
}
