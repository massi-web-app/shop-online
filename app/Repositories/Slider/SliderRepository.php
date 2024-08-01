<?php

namespace App\Repositories\Slider;

use App\Models\Brand;
use App\Models\Slider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SliderRepository implements SliderRepositoryInterface
{

    public function find(int $sliderId): Slider|Model
    {
        return Slider::query()->findOrFail($sliderId);
    }

    public function store(array $data): Slider|Model
    {
        $slider = new Slider($data);
        $slider->save();
        return $slider;
    }

    public function update(Slider $slider, array $data): Slider|Model
    {
        $slider->update($data);
        return $slider;
    }

    public function list(): Builder
    {
        return Slider::query()->orderBy('id', 'desc');
    }

    public function trashed(): Collection|Model
    {
       return Slider::onlyTrashed()->get();
    }

    public function withTrashed(int $sliderId)
    {
        return Slider::withTrashed()->findOrFail($sliderId);
    }
    public function remove_items(array $sliderIds)
    {
        $sliders = Slider::query()->withTrashed()->whereIn('id', $sliderIds)->get();

        foreach ($sliders as $key => $value) {
            if ($value->deleted_at === null) {
                $value->delete();
            } else {
                $value->forceDelete();
            }
        }

    }

    public function restore_items(array $sliderIds)
    {
        $sliders = Slider::onlyTrashed()->whereIn('id', $sliderIds)->get();

        foreach ($sliders as $key => $value) {
           $value->restore();
        }
    }

    public function restore(Model|array|Collection|Builder|\Illuminate\Database\Query\Builder|null $slider)
    {
        $slider->restore();
        return $slider;
    }

    public function delete(int $sliderId)
    {
        $slider = $this->withTrashed($sliderId);
        if ($slider->deleted_at === null) {
            $slider->delete();
            return true;
        }
        $slider->forceDelete();
        return true;
    }
}
