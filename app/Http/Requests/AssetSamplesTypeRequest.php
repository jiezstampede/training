<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AssetSamplesTypeRequest extends Request
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
            'asset_id' => 'required|integer',
            'samples_type_id' => 'required|integer',
            'order' => 'required',
        ];
    }
}
