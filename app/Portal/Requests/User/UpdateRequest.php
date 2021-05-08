<?php

namespace App\Portal\User\Requests;

use App\Portal\Models\User;
use Illuminate\Validation\Rule;

class UpdateRequest extends UserRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = User::findOrFail(request()->id);

        return [
            'first_name' => 'required|string|min:2|max:255',
            'last_name' => 'required|string|min:2|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore(request()->id),
            ],
            'date_of_birth' => 'required|date|date-format:Y-m-d',
            'about' => 'nullable|string|max:500',
            'skills' => [
                $user->hasRole('master') ? 'required' : 'nullable',
            ],
        ];
    }
}
