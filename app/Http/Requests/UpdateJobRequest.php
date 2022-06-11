<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobRequest extends FormRequest
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
            'user_id' => 'required|numeric|not_in:0',
            'place_id' => 'required|numeric',
            'date' => 'required|date_format:Y-m-d',
            'stops_no' => 'required|numeric',
            'AnotherstopsNo' => 'required|numeric',
            'cube_no' => 'required|numeric',
            'percentage' => 'required|numeric|gte:0|lte:100',
            'notes' => 'nullable|string|max:500',
            'helper_id' => 'nullable|numeric',
        ];
    }

    protected function prepareForValidation()
    {
        if($this->helper_id == 0){
            $this->merge([
                'helper_id'=> null,
            ]);
        }
    }
}
