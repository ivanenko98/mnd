<?php

namespace App\Portal\User\Requests;

use App\Core\Http\Requests\BaseRequest;
use App\Portal\Helpers\Acl;
use Illuminate\Support\Facades\Auth;

class CreateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $role = request()->role;
        $currentUser = Auth::user();

        if (
            $role == 'admin' ||
            ($role == 'master' && !$currentUser->hasPermission(Acl::PERMISSION_MASTERS_MANAGE)) ||
            ($role == 'manager' && !$currentUser->hasPermission(Acl::PERMISSION_MANAGERS_MANAGE))
        ) {
            return false;
        }

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
            'first_name' => 'required|string|min:2|max:255',
            'last_name' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ];
    }
}
