<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TransactionRequest extends Request
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
            'date' => '',
            'type' => 'required|max:255',
            'fee_name' => 'required|max:255',
            'amount' => 'required',
            'vat' => 'required',
            'wht' => 'required',
            'paid_status' => 'required|max:255',
            'order_number' => 'required|max:255',
            'order_item_number' => 'required|max:255',
        ];
    }
}
