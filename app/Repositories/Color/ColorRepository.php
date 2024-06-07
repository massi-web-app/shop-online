<?php

namespace App\Repositories\Color;

use App\Models\Category;
use App\Models\Color;
use App\Services\Uploader\Uploader;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ColorRepository implements ColorRepositoryInterface
{


    public function list(string $trashed = null)
    {
        return Color::query()->orderBy('id', 'desc');
    }

    public function trashed(): array|\Illuminate\Database\Eloquent\Collection|Collection
    {
        return Color::onlyTrashed()->get();
    }


    public function store(array $data): Model
    {
        $color = new Color($data);
        $color->save();
        return $color;
    }


    public function find(int $id)
    {
        return Color::query()->findOrFail($id);
    }

    public function withTrashed(int $id)
    {
        return Color::query()->withTrashed()->findOrFail($id);
    }


    public function update(Color $color, array $data): bool
    {
        try {
            $color->update($data);
            $color->save();
            return true;
        } catch (Exception $exception) {
            return false;
        }

    }

    public function delete(int $colorId): bool
    {
        $color = $this->withTrashed($colorId);
        if ($color->deleted_at === null) {
            $color->delete();
            return true;
        }
        $color->forceDelete();
        return true;

    }

    public function remove_items(array $colorIds)
    {
        $categories = Color::query()->withTrashed()->whereIn('id', $colorIds)->get();

        foreach ($categories as $key => $value) {
            if ($value->deleted_at === null) {
                $value->delete();
            } else {
                $value->forceDelete();
            }
        }

    }

    public function restore_items(array $colorIds)
    {
        $categories = Color::query()->onlyTrashed()->whereIn('id', $colorIds)->get();

        foreach ($categories as $key => $value) {
            $value->restore();
        }
    }

    public function restore(Model|\Illuminate\Database\Eloquent\Collection|Builder|array|null $color): Model|\Illuminate\Database\Eloquent\Collection|Builder|array|null
    {
        $color->restore();
        return $color;
    }
}
