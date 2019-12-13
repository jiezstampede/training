<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TeamMemberRequest extends Request
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
            'slug' => 'required|max:255',
            'image' => 'required|max:255|exists:assets,id',
            'background_image' => 'required|max:255',
            'position' => 'max:255',
            'description' => '',
            'order' => 'required|integer',
            'published' => 'required|in:draft,published',
        ];
    }
}
