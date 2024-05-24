<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Services\Uploader\Uploader;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{

    private Uploader $uploader;

    public function __construct(Uploader $uploader)
    {

        $this->uploader = $uploader;
    }

    public function list(): Collection|array
    {
        return Category::get_parent();
    }

    /**
     * @param array $data
     * @return Model
     */
    public function store(array $data): Model
    {
        $category = new Category($data);
        $category->url = $this->getUrl($data['ename']);
        $category->notShow = isset($data['notShow']);
        $category->img = !empty($data['image']) ? $this->uploader->upload($data['image'], 'files/upload') : null;
        $category->save();
        return $category;
    }


    private function getUrl($url): string
    {
        $convertUrlToValidUrlForSearch = str_replace('-', ' ', $url);
        $convertUrlToValidUrlForSearch = str_replace('/', ' ', $convertUrlToValidUrlForSearch);
        return preg_replace('/\s+/', '-', $convertUrlToValidUrlForSearch);
    }
}
