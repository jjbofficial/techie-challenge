<?php

namespace App\Http\Requests\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;

class LoginRequest extends FormRequest
{
    public User $authenticatedUser;
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
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required']
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $user = User::whereEmail($this->email)->first();

                if (!$user) {
                    $validator->errors()->add('email', __('auth.failed'));
                    return;
                }

                if (!Hash::check($this->password, $user->password)) {
                    $validator->errors()->add('email', __('auth.failed'));
                    return;
                }

                $this->authenticatedUser = $user;
            }
        ];
    }
}
