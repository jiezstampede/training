<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EmailRequest extends Request
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
            'subject' => 'required|max:512',
            'to' => 'required|max:512',
            'cc' => 'max:512',
            'bcc' => 'max:512',
            'from_email' => 'required|max:512',
            'from_name' => 'max:512',
            'replyTo' => 'max:512',
            'content' => 'required',
            'attach' => '',
            'status' => 'required|in:pending,sent,failed',
            'sent' => '',
        ];
    }
}
