<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BookRequest extends FormRequest
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
	 * Override validation response code from 422 to 200 as this is an ajax request and handled by vuejs
	 *
	 * @return json
	 */
	protected function failedValidation(Validator $validator)
	{
		throw new HttpResponseException(response([
            'msg' => $validator->errors()->first(),
            'status'=>'error'
        ], 400));
	}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'slug' => 'required',
        ];
    }
}
