<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PageRequest extends Request
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
            'name' => 'max:255',
            'value' => 'max:255',
            'title' => 'max:255',
            'blurb' => 'max:255',
            'button_caption' => 'max:255',
            'slug' => 'max:255',
            'published' => 'in:draft,published',
            'icon_type' => 'in:font-awesome,image',
            'icon_value' => 'max:255',
        ];
    }
}
