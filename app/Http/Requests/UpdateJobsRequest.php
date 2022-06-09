<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobsRequest extends FormRequest
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
            'jobs.*.stops_no' => 'required|numeric',
            'jobs.*.AnotherstopsNo' => 'required|numeric',
            'jobs.*.cube_no' => 'required|numeric',
            'jobs.*.percentage' => 'required|numeric|gte:0|lte:100',
            'jobs.*.notes' => 'nullable|string|max:500',
            'jobs.*.helper_id' => 'nullable|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'jobs.*.stops_no' => 'stops number',
            'jobs.*.AnotherstopsNo' => 'another stops number',
            'jobs.*.cube_no' => 'cube number',
            'jobs.*.percentage' => 'percentage',
            'jobs.*.notes' => 'notes',
            'jobs.*.helper_id' => 'helper',
        ];
    }
}
