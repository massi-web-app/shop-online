<?php

namespace App\Repositories\Slider;

use App\Models\Slider;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface SliderRepositoryInterface
{
    public function store(array $data): Slider|Model;

    public function update(Slider $slider, array $data): Slider|Model;

    public function find(int $sliderId): Slider|Model;

    public function list();

    public function trashed(): Collection|Model;

}
