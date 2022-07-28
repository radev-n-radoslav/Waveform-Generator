<?php

namespace App\Http\Requests\Calls;

use Illuminate\Foundation\Http\FormRequest;

class ProcessDataRequest extends FormRequest
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
            'user_channel' => 'required|mimetypes:text/plain',
            'customer_channel' => 'required|mimetypes:text/plain'
        ];
    }
}
