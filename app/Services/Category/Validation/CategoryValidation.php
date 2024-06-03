<?php

namespace App\Services\Category\Validation;

class CategoryValidation
{

    public function prepareForSave($request)
    {
        return [
            'url' => $this->getUrl($request->get('ename')),
            'notShow' => (bool)$request->has('notShow'),
        ];

    }




    private function getUrl($url): string
    {
        $convertUrlToValidUrlForSearch = str_replace('-', ' ', $url);
        $convertUrlToValidUrlForSearch = str_replace('/', ' ', $convertUrlToValidUrlForSearch);
        return preg_replace('/\s+/', '-', $convertUrlToValidUrlForSearch);
    }

}
