<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CustomController;
use App\Http\Requests\Product\ProductRequest;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Color\ColorRepository;
use App\Services\Product\Service\ProductService;

class ProductController extends CustomController
{

    private ProductService $productService;
    protected $service;
    protected $title = 'محصول';
    protected $route_params = 'product';
    private ColorRepository $colorRepository;
    private BrandRepository $brandRepository;
    private CategoryRepository $categoryRepository;

    public function __construct(ProductService  $productService, ColorRepository $colorRepository, CategoryRepository $categoryRepository,
                                BrandRepository $brandRepository)
    {
        $this->productService = $productService;
        $this->service = $productService;
        $this->colorRepository = $colorRepository;
        $this->brandRepository = $brandRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        return view('product.index');
    }

    public function create()
    {
        $brands = [0 => 'انتخاب برند'];
        $status = $this->productService->getStatusProduct();
        $colors = $this->colorRepository->list()->get();
        $brands = $brands + $this->brandRepository->list()->get()->pluck('name', 'id')->toArray();
        $categories = $this->categoryRepository->list()->get()->pluck('title', 'id')->toArray();
        return view('product.create', ['colors' => $colors, 'brands' => $brands, 'categories' => $categories, 'status' => $status]);
    }

    public function store(ProductRequest $request)
    {
        $this->productService->store($request);
        return redirect()->route('product.index')->with('message','محصول مورد نظر با موفقیت ایجاد گردید');
    }


}
