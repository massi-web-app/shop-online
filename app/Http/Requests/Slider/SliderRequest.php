<?php

namespace App\Http\Requests\Slider;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
{
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
        $rules = [
            'title' => 'required',
            'url' => 'required|url',
            'image_url' => 'required|image',
            'mobile_image_url' => 'required_without:image_url|image'
        ];

        if ($this->method() === 'PUT') {
            $rules['image_url'] = 'image';
            $rules['mobile_image_url']='image';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'title' => 'عنوان اسلایدر',
            'url' => 'آدرس اسلایدر',
            'image_url' => 'تصویر',
            'mobile_image_url' => 'تصویر موبایل'
        ];
    }
}
