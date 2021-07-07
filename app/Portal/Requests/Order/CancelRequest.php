<?php

namespace App\Portal\Order\Requests;

use App\Core\Http\Requests\BaseRequest;
use App\Core\Rules\PhoneNumber;
use App\Portal\Helpers\Acl;
use App\Portal\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CancelRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $currentUser = Auth::user();

        return $currentUser->hasPermission(Acl::PERMISSION_ORDERS_MANAGE);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cancel_reason' => 'required|string'
        ];
    }
}
