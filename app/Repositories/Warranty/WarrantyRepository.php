<?php

namespace App\Repositories\Warranty;

use App\Models\Brand;
use App\Models\Warranty;
use Illuminate\Database\Eloquent\Model;
use Mockery\Exception;

class WarrantyRepository implements WarrantyRepositoryInterface
{

    public function list(string $trashed = null)
    {
        return Warranty::query()->orderBy('id', 'desc');
    }

    public function store(array $data): Model
    {
        $warranty = new Warranty($data);
        $warranty->save();
        return $warranty;
    }

    public function find(int $id)
    {
        return Warranty::query()->findOrFail($id);
    }

    public function update(Warranty|Model $warranty, array $data): bool
    {
        try {
            $warranty->update($data);
            $warranty->save();
            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    public function withTrashed(int $id)
    {
        return Warranty::query()->withTrashed()->findOrFail($id);
    }
    public function delete(int $warrantyId): bool
    {
        $warranty = $this->withTrashed($warrantyId);
        if ($warranty->deleted_at === null) {
            $warranty->delete();
            return true;
        }
        $warranty->forceDelete();
        return true;
    }



    public function remove_items(array $warrantyIds)
    {
        $warranties = Warranty::query()->withTrashed()->whereIn('id', $warrantyIds)->get();

        foreach ($warranties as $key => $value) {
            if ($value->deleted_at === null) {
                $value->delete();
            } else {
                $value->forceDelete();
            }
        }
    }

    public function restore_items(array $warrantyIds)
    {
        $warranties = Warranty::query()->onlyTrashed()->whereIn('id', $warrantyIds)->get();

        foreach ($warranties as $key => $value) {
            $value->restore();
        }
    }

    public function restore(Model|Warranty $warranty): Warranty
    {
        $warranty->restore();
        return $warranty;
    }

    public function trashed()
    {
        return Warranty::onlyTrashed()->get();
    }

}
