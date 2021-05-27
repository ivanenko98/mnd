<?php

namespace App\Portal\Order\Requests;

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
            'phone_number' => 'required|string|min:2|max:255',
            'services' => 'required|array',
            'services.*' => 'integer|exist:services,id',
            'city_id' => 'required|exist:cities,id',
            'address' => 'required|string',
            'comment' => 'required|string',
        ];
    }
}
