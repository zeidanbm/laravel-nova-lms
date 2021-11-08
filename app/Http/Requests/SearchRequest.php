<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SearchRequest extends FormRequest
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
            's' => 'required|min:3',
            'page' => 'nullable',
            'per_page' => 'nullable',
            'book_fields' => 'nullable',
            'topics' => 'nullable',
            'sub_topics' => 'nullable',
            'types' => 'nullable',
            'authors' => 'nullable',
            'tags' => 'nullable'
		];
    }
}
