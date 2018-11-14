<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class BannerRequest extends Request
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
            'caption' => 'max:512',
            'published' => 'required|in:draft,published',
            'order' => 'integer',
            'image' => 'max:512|exists:assets,id',
            'image_thumbnail' => 'max:512',
            'link' => 'max:512',
        ];
    }
}
