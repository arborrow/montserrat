<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAssetTaskRequest extends FormRequest
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
						'id' => 'integer|min:1|required',
						'asset_id' => 'integer|min:0|exists:asset,id|required',
						'title' => 'string|max:250|required',
						'start_date' => 'date|required',
						'scheduled_until_date' => 'date|required',
						'frequency' => 'in:'.implode(',', config('polanco.asset_task_frequency')).'|required',
            'frequency_interval' => 'required|integer|between:1,365',
            'frequency_month' => 'integer|nullable',
            'frequency_day' => 'integer|nullable',
            'frequency_time' => 'date_format:H:i|nullable',
						'description' => 'string|nullable',
						'priority_id' => 'in:'.implode(',', config('polanco.priority')).'|required',
						'needed_labor_minutes' => 'integer|nullable',
						'estimated_labor_cost' => 'numeric|min:0|nullable',
						'needed_material' => 'string|nullable',
						'estimated_material_cost' => 'numeric|min:0|nullable',
						'vendor_id' => 'integer|min:0|exists:contact,id|nullable',
						'category' => 'string|nullable',
						'tag' => 'string|nullable',
				];
		}

		/**
		 * Get the error messages for the defined validation rules.
		 *
		 * @return array
		 */
		public function messages()
		{
				return [];
		}
}
