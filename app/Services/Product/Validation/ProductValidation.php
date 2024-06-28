<?php

namespace App\Services\Product\Validation;

class ProductValidation
{
    public function prepareForSave($request)
    {
        return [
            'product_url' => $this->getUrl($request->get('ename')),
        ];

    }


    private function getUrl($url): string
    {
        $convertUrlToValidUrlForSearch = str_replace('-', ' ', $url);
        $convertUrlToValidUrlForSearch = str_replace('/', ' ', $convertUrlToValidUrlForSearch);
        return preg_replace('/\s+/', '-', $convertUrlToValidUrlForSearch);
    }

}
