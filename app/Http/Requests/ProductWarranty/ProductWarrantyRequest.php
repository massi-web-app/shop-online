<?php

namespace App\Http\Requests\ProductWarranty;

use Illuminate\Foundation\Http\FormRequest;

class ProductWarrantyRequest extends FormRequest
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
        return [
            'warranty_id' => ['required', 'exists:warranties,id'],
            'color_id' => ['required', 'exists:colors,id'],
            'real_product_price' => ['required', 'numeric'],
            'sale_product_price' => ['required', 'numeric'],
            'product_number' => ['nullable', 'numeric'],
            'product_number_cart' => ['nullable', 'numeric'],
            'send_time' => ['nullable', 'numeric'],
        ];
    }

    public function attributes()
    {
        return [
            'warrant_id' => ' نوع گارانتی',
            'color_id' => 'رنگ محصول',
            'real_product_price' => 'قیمت محصول',
            'sale_product_price' => 'قیمت برای فروش محصول',
            'product_number' => 'موجودی محصول',
            'product_number_cart' => 'تعداد محصول در هر سبد خرید',
            'send_time' => 'آماده سازی محصول',
        ];
    }

    public function getValidatorInstance()
    {
        if ($this->request->has('real_product_price')) {
            $this->merge([
                'real_product_price' => str_replace(',', '',$this->get('real_product_price')),

            ]);
        }

        if ($this->request->has('sale_product_price')) {
            $this->merge([
                'sale_product_price' => str_replace(',', '',$this->get('sale_product_price')),
            ]);
        }

        if ($this->request->has('send_time')) {
            $this->merge([
                'send_time' => str_replace(',', '',$this->get('send_time')),
            ]);
        }


        if ($this->request->has('product_number')) {
            $this->merge([
                'product_number' => str_replace(',', '',$this->get('product_number')),
            ]);
        }

        if ($this->request->has('product_number_cart')) {
            $this->merge([
                'product_number_cart' => str_replace(',', '',$this->get('product_number_cart')),
            ]);
        }


        return parent::getValidatorInstance();

    }
}
