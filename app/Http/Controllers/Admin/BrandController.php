<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CustomController;
use App\Http\Requests\Admin\BrandRequest;
use App\Repositories\Brand\BrandRepository;
use App\Services\Brand\Service\BrandService;
use App\Services\Category\Service\CategoryService;
use App\Services\Uploader\Uploader;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BrandController extends CustomController
{
    private BrandService $brandService;
    private Uploader $uploader;
    protected $service;
    protected $title = 'برد';
    protected $route_params = 'brand';
    private BrandRepository $brandRepository;

    public function __construct(BrandService $brandService, Uploader $uploader, BrandRepository $brandRepository)
    {
        $this->brandService = $brandService;
        $this->uploader = $uploader;
        $this->service = $brandService;
        $this->brandRepository = $brandRepository;
    }

    public function index(Request $request)
    {
        $categories = $this->brandService->list($request);
        $paginate = CategoryService::$paginate;
        $trashed_category_count = $this->brandService->countTrashed();
        return view('brand.index', ['brands' => $categories, 'paginate' => $paginate,
            'trashed_brand_count' => $trashed_category_count, 'request' => $request]);
    }

    public function create()
    {
        return view('brand.create');
    }

    public function store(BrandRequest $request): RedirectResponse
    {
        $data = $request->all();
        $image = $this->uploader->upload($request->file('image'), 'files/upload');
        $data['icon'] = $image;
        $this->brandService->store($data);
        return redirect()->route('brand.index')->with('message', 'ثبت برند با موفقیت انجام شد.');
    }


    public function edit(int $categoryId): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $brand = $this->brandRepository->find($categoryId);
        return view('brand.edit', ['brand' => $brand]);
    }


    public function update(int $brandId, BrandRequest $request): RedirectResponse
    {
        $this->brandService->update($brandId,$request);
        return redirect()->route('brand.index')->with('message', 'ویرایش برند با موفقیت انجام شد.');
    }


}
