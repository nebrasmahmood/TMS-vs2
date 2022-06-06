<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
            'name'=>'required|string|max:255',
            'description'=>'nullable|string|max:500',
            'status'=>'required|numeric|digits_between:0,1',
        ];
    }

    protected function prepareForValidation()
    {
        if(!$this->status){
            $this->merge([
                'status'=> 0,
            ]);
        }
    }
}
