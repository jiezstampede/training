<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class OrderItemRequest extends Request
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
     * @return array
     */
    public function rules()
    {
        return [
            'number' => 'required|max:255',
            'order_id' => 'required|integer',
            'order_number' => 'required|max:255',
            'seller_sku' => 'required|max:255',
            'lazada_sku' => 'required|max:255',
            'details' => 'required|max:500',
            'shipping_provider' => 'required|max:500',
            'delivery_status' => 'required|max:500',
            'subtotal' => 'required',
            'shipping_paid' => 'required',
            'shipping_charged' => 'required',
            'payment_fee' => 'required',
        ];
    }
}
