<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CustomController;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Color\ColorRepository;
use App\Repositories\Product\ProductRepository;
use App\Services\Product\ProductService;
use App\Services\Uploader\Uploader;

class ProductController extends CustomController
{

    private ProductService $productService;
    private Uploader $uploader;
    protected $service;
    protected $title = 'محصول';
    protected $route_params = 'product';
    private ProductRepository $productRepository;
    private ColorRepository $colorRepository;
    private BrandRepository $brandRepository;
    private CategoryRepository $categoryRepository;

    public function __construct(ProductService  $productService, ColorRepository $colorRepository, CategoryRepository $categoryRepository,
                                BrandRepository $brandRepository, Uploader $uploader, ProductRepository $productRepository)
    {
        $this->productService = $productService;
        $this->uploader = $uploader;
        $this->service = $productService;
        $this->productRepository = $productRepository;
        $this->colorRepository = $colorRepository;
        $this->brandRepository = $brandRepository;
        $this->categoryRepository = $categoryRepository;
    }


    public function create()
    {
        $brands = [0 => 'انتخاب برند'];
        $colors = $this->colorRepository->list();
        $brands = $brands + $this->brandRepository->list()->get()->pluck('name', 'id')->toArray();
        $categories = $this->categoryRepository->list()->get()->pluck('title', 'id')->toArray();
        return view('product.create', ['colors' => $colors, 'brands' => $brands, 'categories' => $categories]);
    }


}
