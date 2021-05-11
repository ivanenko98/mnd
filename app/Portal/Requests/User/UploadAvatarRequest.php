<?php

namespace App\Portal\User\Requests;

use App\Portal\Models\User;
use Illuminate\Validation\Rule;

class UploadAvatarRequest extends UserRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'avatar' => 'required|image|max:5000',
        ];
    }
}
