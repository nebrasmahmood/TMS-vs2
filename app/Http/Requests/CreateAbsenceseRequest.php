<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAbsenceseRequest extends FormRequest
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
            'date'   => 'required|date_format:Y-m-d',
            'reason' => 'required|numeric',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->absent_user_id,
            'date' => $this->adsent_date,
        ]);
    }
}
