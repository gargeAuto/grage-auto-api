<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class SignupRequest extends FormRequest
{
    
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        
        return [
            "name" => "required|string|max:55",
            "email" => "required|email|unique:users,email",
            'surname' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            "password" => [
                "required",
                Password::min(8)
                ->letters()
                ->symbols(),
                "confirmed"
                ]
        ];
    }
    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();
        $firstError = $errors[0] ?? 'Erreur de validation.';

        throw new HttpResponseException(
            response()->json([
                'message' => $firstError
            ], 422)
        );
    }
}
