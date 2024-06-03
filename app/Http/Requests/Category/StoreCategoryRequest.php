<?php

namespace App\Http\Requests\Category;

use App\Services\Category\Validation\CategoryValidation;
use App\Services\Category\Validation\CategoryValidationFactory;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{


    private CategoryValidation $categoryValidation;

    public function __construct(CategoryValidation $categoryValidation)
    {
        parent::__construct();
        $this->categoryValidation = $categoryValidation;
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'search_url' => 'required_without:ename',
            'image' => 'nullable|image'
        ];
    }

    public function attributes()
    {
        return [
            'ename' => 'نام لاتین',
            'search_url' => 'url دسته',
            'image' => 'تصویر دسته'
        ];
    }

    public function passedValidation()
    {
        $this->merge($this->categoryValidation->prepareForSave($this));
    }
}
