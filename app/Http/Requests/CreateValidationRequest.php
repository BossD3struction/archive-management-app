<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $year = date("Y");
        return [
            'name' => 'required|unique:cars',
            'founded' => 'required|integer|min:0|max:' . $year,
            'description' => 'required'
        ];
    }
}
