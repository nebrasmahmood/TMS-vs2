<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
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
            'title'=>'required|string|max:255',
            'place_id'=>'required|numeric|not_in:0',
            'busNo'=>'required|numeric|not_in:0',
            'start_km'=>'required|numeric|lt:end_km',
            'end_km'=>'required|numeric|gt:start_km',
            'date'=>'required|date_format:Y-m-d',
            'start'=>'required|date_format:g:i A',
            'end'=>'required|date_format:g:i A',
            'stopsNum'=>'required|numeric',
            'user_id' => 'required|numeric',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id'=> auth()->id(),
        ]);
    }
}
