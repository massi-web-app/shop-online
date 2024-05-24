<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository implements CategoryRepositoryInterface
{

    /**
     * @param array $data
     * @return Model
     */
    public function store(array $data): Model
    {
        $this->getUrl($data['ename']);
        return Category::query()->create([
            'title' => $data['title'],
            'ename' => $data['ename'],
            'url' => $this->getUrl($data['ename']),
            'nowShow' => isset($data['notShow']),
            'search_url' => $data['search_url']
        ]);
    }


    private function getUrl($url): string
    {
        $convertUrlToValidUrlForSearch = str_replace('-', ' ', $url);
        $convertUrlToValidUrlForSearch = str_replace('/', ' ', $convertUrlToValidUrlForSearch);
        return preg_replace('/\s+/', '-', $convertUrlToValidUrlForSearch);
    }
}
