<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TeamMemberSocialRequest extends Request
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
            'team_member_id' => 'required|integer',
            'name' => 'required|max:255',
            'icon_type' => 'required|in:font-awesome,image',
            'icon_value' => 'max:512',
            'icon_color' => 'max:512',
            'link' => '',
            'order' => 'required|integer',
            'published' => 'required|in:draft,published',
        ];
    }
}
