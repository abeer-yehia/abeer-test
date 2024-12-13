<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => [ 'string', 'max:255'],
            'email' => [
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'profile_picture' => 'nullable|image|mimes:jpg,png|max:2048', 

        ];
        $rules['name'][] = $this->isMethod('put') ? 'nullable' : 'required'; 
        $rules['email'][] = $this->isMethod('put') ? 'nullable' : 'required';
        return $rules;
    }
    public function messages()
    {
        return [
            'profile_picture.mimes' => 'The profile picture must be a file of type:  jpg, png.',
        ];
    }
}
