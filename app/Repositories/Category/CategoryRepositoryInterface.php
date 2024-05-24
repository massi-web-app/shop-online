<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    public function list():array | Collection;

    public function store(array $data):Model;

}
