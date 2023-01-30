<?php

namespace App\Http\Requests\ProductUser;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class ProductUserRequest extends FormRequest
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
            'user_id' => ['required', 'exists:'.User::class.',id'],
            'product_id' => ['required', 'exists:'.Product::class.',id'],
            'quantity' => ['required', 'numeric', 'integer'],
        ];
    }
}
