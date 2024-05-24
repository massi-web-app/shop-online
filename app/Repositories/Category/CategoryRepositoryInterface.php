<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

interface CategoryRepositoryInterface
{
    public function store(array $data):Model;

}
