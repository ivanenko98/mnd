<?php

namespace App\Portal\User\Requests;

use App\Core\Http\Requests\BaseRequest;
use App\Portal\Helpers\Acl;
use App\Portal\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = request()->user;

        if ($user == null)
            $user = User::findOrFail(request()->id);

        $currentUser = Auth::user();

        if (
            ($user->hasRole(['admin'])) ||
            ($user->hasRole(['master']) && !$currentUser->hasPermission(Acl::PERMISSION_MASTERS_MANAGE)) ||
            ($user->hasRole(['manager']) && !$currentUser->hasPermission(Acl::PERMISSION_MANAGERS_MANAGE))
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
            //
        ];
    }
}
