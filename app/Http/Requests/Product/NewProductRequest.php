<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class NewProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'max:255'],
            'description' => ['required', 'max:2550'],
            'image' => [
                'required', 'file',
                //'mimes:png',
                // max file size in kB
                //'max:1024',
                // for images, specify dimension constraints
                //'dimensions:min_width=500,max_width=1500'
            ],
            'price' => ['required', 'integer'],
            'quantity' => ['required', 'integer'],
            'category_id' => ['required', 'exists:App\Models\Category,id'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
