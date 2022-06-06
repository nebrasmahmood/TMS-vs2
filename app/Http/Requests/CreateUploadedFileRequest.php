<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class CreateUploadedFileRequest extends FormRequest
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
            'admin_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'file_name' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id'=> Route::current()->parameter('user'),
            'admin_id'=> auth()->id(),
        ]);
    }
}
