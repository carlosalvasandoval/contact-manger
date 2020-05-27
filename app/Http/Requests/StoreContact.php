<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreContact extends FormRequest
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
			'first_name' => 'required|max:255',
			'email'=>[
				'required',
				'email',
				Rule::unique('contacts', 'email')->where(function ($query)  {
					return $query->where('user_id', $this->user_id);
				})->ignore($this->contact),

			],
			'phone' => 'min:5',
		];
	}
}
