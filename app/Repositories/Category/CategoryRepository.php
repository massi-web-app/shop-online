<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Services\Uploader\Uploader;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{

    private Uploader $uploader;


    public function __construct(Uploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function list(string $trashed = null)
    {
        return Category::query()->with('getParent')->orderBy('id', 'desc');
    }

    public function trashed(): array|\Illuminate\Database\Eloquent\Collection|Collection
    {
        return Category::onlyTrashed()->get();
    }

    public function getChildAndCategories(): Collection|array
    {
        return Category::getChildAndCategories();
    }

    /**
     * @param array $data
     * @return Model
     */
    public function store(array $data): Model
    {
        $category = new Category($data);
        $category->save();
        return $category;
    }


    public function find(int $id)
    {
        return Category::query()->findOrFail($id);
    }


    public function update(Category $category, array $data): bool
    {
        try {
            $category->update($data);
            $category->save();
            return true;
        } catch (Exception $exception) {
            return false;
        }

    }

    public function delete(int $categoryId): bool
    {
        $category = $this->find($categoryId);
        $category->delete();
        return true;
    }
}
