<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CustomController;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Filter;
use App\Models\Item;
use App\Models\Product;
use App\Models\ProductFilters;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Color\ColorRepository;
use App\Services\Product\Service\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends CustomController
{

    private ProductService $productService;
    protected $service;
    protected $title = 'محصول';
    protected $route_params = 'product';
    private ColorRepository $colorRepository;
    private BrandRepository $brandRepository;
    private CategoryRepository $categoryRepository;

    public function __construct(ProductService $productService, ColorRepository $colorRepository, CategoryRepository $categoryRepository, BrandRepository $brandRepository)
    {
        $this->productService = $productService;
        $this->service = $productService;
        $this->colorRepository = $colorRepository;
        $this->brandRepository = $brandRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request)
    {
        $products = $this->productService->list($request);
        $trashed_product_count = $this->productService->countTrashed();
        $paginate = ProductService::$paginate;
        return view('product.index', ['products' => $products, 'trashed_product_count' => $trashed_product_count,
            'request' => $request, 'paginate' => $paginate]);
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
        return redirect()->route('product.index')->with('message', 'محصول مورد نظر با موفقیت ایجاد گردید');
    }

    public function edit(int $productId)
    {
        $product = $this->productService->find($productId);
        $product_colors = $product->productColors()->get()->pluck('id', 'id')->toArray();
        $brands = [0 => 'انتخاب برند'];
        $status = $this->productService->getStatusProduct();
        $colors = $this->colorRepository->list()->get();
        $brands = $brands + $this->brandRepository->list()->get()->pluck('name', 'id')->toArray();
        $categories = $this->categoryRepository->list()->get()->pluck('title', 'id')->toArray();
        return view('product.edit', [
            'colors' => $colors, 'brands' => $brands, 'categories' => $categories,
            'status' => $status, 'product' => $product, 'product_colors' => $product_colors]);
    }


    public function update(ProductRequest $request, int $productId): RedirectResponse
    {
        $this->productService->update($request, $productId);
        return redirect()->route('products.index')->with('message', 'محصول مورد نظر با موفقیت ویرایش شد.');
    }

    public function gallery(int $productId)
    {
        $galleries = $this->productService->listGalleries($productId);
        $product = $this->productService->find($productId);
        return view('products.gallery', ['product' => $product, 'galleries' => $galleries]);

    }

    public function gallerySave(int $productId, Request $request)
    {
        return $this->productService->uploadGallery($productId, $request);
    }

    public function removeImageFromGallery(int $imageId)
    {
        $result = $this->productService->removeGalleryFromGallery($imageId);
        if ($result) {
            return redirect()->back()->with('message', 'تصویر مورد نظر با موفقیت حذف گردید');
        }
    }

    public function sortImage(int $productId, Request $request)
    {
        $parameters = $request->get('parameters');
        $parameters = explode(',', $parameters);
        return $this->productService->sortGallery($parameters);
    }

    public function items(int $productId)
    {
        $product = $this->productService->find($productId);
        $data = Item::getProductItemWithFilter($product);
        $product_items=$data['items'];
        $filters=$data['filters'];
        $product_filters=ProductFilters::query()->where('product_id',$product->id)->pluck('filter_id','filter_value')->toArray();
        return view('product.items', ['product_items' => $product_items, 'product' => $product,'filters'=>$filters,'product_filters'=>$product_filters]);
    }

    public function add_items(int $productId, Request $request)
    {
        define('product_id',$productId);
        $data = $request->get('item_value');
        $filter_value=$request->get('filter_value');
        $product = $this->productService->find($productId);
        $this->productService->add_items($product, $data,$filter_value);
        return redirect()->back()->with('message', 'ثبت مشخصات فنی برای محصول انجام شد.');
    }


    public function filters(int $productId)
    {
        $product = $this->productService->find($productId);
        $product_filters = $this->productService->getFilters($product);
        return view('product.filters', ['product_filters' => $product_filters, 'product' => $product]);

    }

    public function add_filters(int $product_id, Request $request)
    {
        $product = Product::query()->where('id', $product_id)->select(['id', 'title', 'category_id'])->first();
        $filters = $request->get('filters');
        ProductFilters::query()->where(['product_id' => $product_id])->delete();

        if (is_array($filters)) {
            foreach ($filters as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $key2 => $value2) {
                        ProductFilters::query()->create([
                            'product_id' => $product->id,
                            'filter_id' => $key,
                            'filter_value' => $value2
                        ]);
                    }
                }
            }
        }

        return redirect()->back()->with('message', 'ثبت مشخصات فیلتر برای محصول انجام شد.');
    }


}
