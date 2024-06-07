<?php

namespace App\Services\Brand\Service;

use App\Helper\Helper;
use App\Repositories\Brand\BrandRepository;
use App\Services\Uploader\Uploader;
use Illuminate\Http\Request;

class BrandService
{
    private BrandRepository $brandRepository;

    public static int $paginate = 10;
    private Uploader $uploader;


    public function __construct(BrandRepository $brandRepository, Uploader $uploader)
    {
        $this->brandRepository = $brandRepository;
        $this->uploader = $uploader;
    }

    public function list(Request $request)
    {
        $queryString = '?';
        $brands = $this->brandRepository->list();
        if ($request->get('trashed') == 'true') {
            $brands = $brands->onlyTrashed();
            $queryString = Helper::generateQueryString($queryString, 'trashed=true');
        }

        if (array_key_exists('string', $request->all()) && !empty($request->get('string'))) {
            $brands = $brands->where('name', 'like', '%' . $request->get('string') . '%');
            $brands = $brands->orWhere('ename', 'like', '%' . $request->get('string') . '%');
            $queryString = Helper::generateQueryString($queryString, 'string=' . $request->get('string'));
        }

        $brands = $brands->paginate(self::$paginate);
        $brands->withPath($queryString);
        return $brands;
    }

    public function delete(int $categoryId)
    {
        $this->brandRepository->delete($categoryId);
    }

    public function countTrashed()
    {
        return $this->brandRepository->trashed()->count();
    }

    public function removeItems(Request $request)
    {
        $this->brandRepository->remove_items($request->get('brand_id'));

    }

    public function restoreItems(Request $request)
    {
        $this->brandRepository->restore_items($request->get('brand_id'));
    }

    public function restore(int $categoryId)
    {
        $category = $this->brandRepository->withTrashed($categoryId);
        $this->brandRepository->restore($category);
        return true;
    }

    public function store(array $data)
    {
        $this->brandRepository->store($data);
    }

    public function update(int $brandId, Request $request)
    {
        $brand = $this->brandRepository->find($brandId);
        $data = $request->all();
        if ($request->hasFile('image')){
            $this->uploader->removeFile('files/upload', $brand->icon);
            $image = $this->uploader->upload($request->file('image'), 'files/upload');
            if (!empty($image)) {
                $data['icon'] = $image;
            }
        }

        $this->brandRepository->update($brand, $data);
        return $brand;
    }

}
