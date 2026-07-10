<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'customer_address' => ['nullable', 'required_if:order_type,delivery', 'string', 'max:1000'],
            'order_type' => ['required', 'in:delivery,pickup,dine_in'],
            'dining_table_id' => ['nullable', 'required_if:order_type,dine_in', 'exists:dining_tables,id'],
            'payment_method' => ['required', 'in:cash,card'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
