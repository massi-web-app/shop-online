<?php

namespace App\Http\Requests\Product;

use App\Services\Product\Validation\ProductValidation;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    private ProductValidation $productValidation;

    public function __construct(ProductValidation $productValidation)
    {
        parent::__construct();
        $this->productValidation = $productValidation;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|min:2|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'description' => 'required|max:150',
            'product_color_id' => 'required|array',
            'product_color_id.*' => 'exists:colors,id',
            'image_url' => 'required|image|max:1024'
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'عنوان محصول',
            'category_id' => 'دسته محصول',
            'brand_id' => 'برند محصول',
            'description' => 'توضیحات',
            'product_color_id' => 'رنگ های محصول'

        ];
    }


    public function passedValidation()
    {
        $this->merge($this->productValidation->prepareForSave($this));
    }
}
