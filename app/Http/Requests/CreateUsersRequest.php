<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUsersRequest extends FormRequest
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
        $id = $this->user->id ?? '';
        $rules = [
            'fname'=>'required|max:255',
            'lname'=>'required|max:255',
            'email'=>'required|email|max:255|unique:users,email,' . $id,
            'busNo'=>'required_if:role,==,0|max:20',
            'role'=>'required',
        ];
        if($this->routeIs('users.update') && isset($this->password)){
            $rules['password'] = 'required|min:6|max:255';
        }

        return $rules;
    }
}
