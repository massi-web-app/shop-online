<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Services\Uploader\Uploader;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository implements CategoryRepositoryInterface
{

    private Uploader $uploader;

    public function __construct(Uploader $uploader)
    {

        $this->uploader = $uploader;
    }

    /**
     * @param array $data
     * @return Model
     */
    public function store(array $data): Model
    {
        return Category::query()->create([
            'title' => $data['title'],
            'ename' => $data['ename'],
            'url' => $this->getUrl($data['ename']),
            'nowShow' => isset($data['notShow']),
            'search_url' => $data['search_url'],
            'img' => $this->uploader->upload($data['image'],'files/upload')
        ]);
    }


    private function getUrl($url): string
    {
        $convertUrlToValidUrlForSearch = str_replace('-', ' ', $url);
        $convertUrlToValidUrlForSearch = str_replace('/', ' ', $convertUrlToValidUrlForSearch);
        return preg_replace('/\s+/', '-', $convertUrlToValidUrlForSearch);
    }
}
