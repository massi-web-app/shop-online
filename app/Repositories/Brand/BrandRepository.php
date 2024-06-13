<?php

namespace App\Repositories\Brand;

use App\Models\Brand;
use App\Models\Category;
use App\Services\Uploader\Uploader;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BrandRepository implements BrandRepositoryInterface
{


    public function list(string $trashed = null)
    {
        return Brand::query()->orderBy('id', 'desc');
    }

    public function trashed(): array|\Illuminate\Database\Eloquent\Collection|Collection
    {
        return Brand::onlyTrashed()->get();
    }

    public function store(array $data): Model
    {
        $brand = new Brand($data);
        $brand->save();
        return $brand;
    }

    public function find(int $id)
    {
        return Brand::query()->findOrFail($id);
    }

    public function withTrashed(int $id)
    {
        return Brand::query()->withTrashed()->findOrFail($id);
    }

    public function update(Brand $brand, array $data): bool
    {
        try {
            $brand->update($data);
            $brand->save();
            return true;
        } catch (Exception $exception) {
            return false;
        }

    }

    public function delete(int $brandId): bool
    {
        $brand = $this->withTrashed($brandId);
        if ($brand->deleted_at === null) {
            $brand->delete();
            return true;
        }
        $brand->forceDelete();
        return true;

    }

    public function remove_items(array $brandIds)
    {
        $brands = Brand::query()->withTrashed()->whereIn('id', $brandIds)->get();

        foreach ($brands as $key => $value) {
            if ($value->deleted_at === null) {
                $value->delete();
            } else {
                $value->forceDelete();
            }
        }

    }

    public function restore_items(array $brandIds)
    {
        $brands = Brand::query()->onlyTrashed()->whereIn('id', $brandIds)->get();

        foreach ($brands as $key => $value) {
            $value->restore();
        }
    }

    public function restore(Model|\Illuminate\Database\Eloquent\Collection|Builder|array|null $brand): Model|\Illuminate\Database\Eloquent\Collection|Builder|array|null
    {
        $brand->restore();
        return $brand;
    }
}
