<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TestRequest extends Request
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
            'name' => 'required|max:255',
            'slug' => 'max:255',
            'date' => '',
            'tinyint' => '',
            'order' => 'integer',
            'integer' => 'required|integer',
            'image' => 'max:255',
            'image_thumbnail' => 'max:512',
            'enum' => 'required|in:one,two',
            'text' => '',
        ];
    }
}
