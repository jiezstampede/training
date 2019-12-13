<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PageItemRequest extends Request
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
            'page_id' => 'required|integer',
            'slug' => 'required',
            'title' => 'max:255',
            'value' => '',
            'description' => '',
            'image' => 'max:255|exists:assets,id',
            'order' => 'required|integer',
            'json_data' => '',
        ];
    }
}
