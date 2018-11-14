<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ArticleRequest extends Request
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
            'blurb' => 'max:255',
            'date' => '',
            'featured' => '',
            'published' => 'required|in:draft,published',
            'content' => 'required',
            'image' => 'max:512|exists:assets,id',
            'image_thumbnail' => 'max:512',
            'author' => 'max:255',
        ];  
    }
}
