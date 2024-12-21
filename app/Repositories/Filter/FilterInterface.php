<?php

namespace App\Repositories\Filter;

use App\Models\Category;
use App\Models\Filter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface FilterInterface
{

    public function addFilter(Collection|Model $category, array $child_filter, array $filter,$item_value);

}
