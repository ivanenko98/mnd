<?php

namespace App\Portal\Order\Requests;

use App\Core\Http\Requests\BaseRequest;
use App\Core\Rules\PhoneNumber;
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
            'phone_number' => ['required', new PhoneNumber],
            'services' => 'required|array',
//            'services.*' => 'integer|exist:services,id',
            'city' => 'required|exists:cities,id',
            'address' => 'required|string',
            'comment' => 'nullable|string',
        ];
    }
}
