<?php

namespace App\Portal\Controllers\Api;

use App\Core\Traits\FormatResponse;
use App\Http\Resources\MasterResource;
use App\Http\Resources\OrderEditResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\UserResource;
use App\Portal\Helpers\Acl;
use App\Portal\Models\Order;
use App\Portal\Models\Permission;
use App\Portal\Models\Role;
use App\Portal\Models\User;
use App\Portal\Order\Requests\CancelRequest;
use App\Portal\Order\Requests\CreateRequest;
use App\Portal\Order\Requests\UpdateRequest;
use App\Portal\User\Requests\UploadAvatarRequest;
use App\Portal\User\Requests\UserRequest;
use Carbon\Carbon;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Validator;

/**
 * Class OrderController
 *
 * @package App\Http\Controllers\Api
 */
class OrderController extends BaseController
{
    use FormatResponse;

    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the user resource.
     *
     * @param Request $request
     * @return Response|ResourceCollection
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $searchParams = $request->all();
        $query = Order::query();

        $limit = Arr::get($searchParams, 'limit', static::ITEM_PER_PAGE);
        $keyword = Arr::get($searchParams, 'keyword', '');

        if ($user->hasRole('master')) {
            $query->where('master_id', $user->id);
        }

        if (!empty($keyword)) {
            $query->where('phone_number', 'LIKE', '%' . $keyword . '%');
            $query->orWhereHas('master', function ($q) use ($keyword) {
                return $q->whereRaw("concat(first_name, ' ', last_name) like '%$keyword%'");
            });
            $query->orWhereHas('city', function ($q) use ($keyword) {
                return $q->where('title', 'LIKE', '%' . $keyword . '%');
            });
            $query->orWhere('address', 'LIKE', '%' . $keyword . '%');
        }

        return OrderResource::collection($query->orderBy('created_at', 'desc')->paginate($limit));
    }

    public function store(CreateRequest $request)
    {
        $order = Order::create([
            'phone_number' => $request->phone_number,
            'city_id' => $request->city,
            'address' => $request->address,
            'comment' => $request->comment,
        ]);

        $order->services()->attach($this->parseServices($request->services));

        $response = $this->formatResponse('success', null, new OrderResource($order));
        return response($response, 200);
    }
//

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return ResponseFactory|Response
     */
    public function show(Order $order)
    {
        $user = Auth::user();

        if ($user->hasRole('master')) {
            $data = new OrderResource($order);
        } else {
            $data = new OrderEditResource($order);
        }

        $response = $this->formatResponse('success', null, $data);
        return response($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Order $order
     * @return ResponseFactory|Response
     */
    public function update(UpdateRequest $request, Order $order)
    {
        $order->update([
            'phone_number' => $request->phone_number,
            'city_id' => $request->city,
            'master_id' => $request->master,
            'address' => $request->address,
            'comment' => $request->comment,
            'status' => $request->status,
            'total_cost' => $request->total_cost,
        ]);

        $order->services()->sync($this->parseServices($request->services));

        $response = $this->formatResponse('success', null, new OrderResource($order));
        return response($response, 200);
    }

    public function cancel(CancelRequest $request, Order $order)
    {
        $order->update([
            'cancel_reason' => $request->cancel_reason,
            'status' => Order::CANCELLED,
        ]);

        $response = $this->formatResponse('success', null, new OrderResource($order));
        return response($response, 200);
    }
//
//    /**
//     * Upload avatar.
//     *
//     * @param UploadAvatarRequest $request
//     * @param $id
//     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
//     */
//    public function uploadAvatar(UploadAvatarRequest $request, User $user)
//    {
//        $photo = $request->avatar;
//
//        $name = uniqid($user->id . '_') . "." . $photo->getClientOriginalExtension();
//        Storage::putFileAs('/public/uploads/avatars/' . $user->id . '/', $photo, $name);
//
//        $link = Storage::url('uploads/avatars/' . $user->id . '/' . $name);
//
//        $user->update(['avatar' => $link]);
//
//        $response = $this->formatResponse('success', null, $link);
//        return response($response, 201);
//    }
//
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param UserRequest $request
//     * @param User $user
//     * @return \Illuminate\Http\Response
//     */
//    public function destroy(UserRequest $request, User $user)
//    {
//        try {
//            $user->delete();
//        } catch (\Exception $ex) {
//            $response = $this->formatResponse('error', $ex->getMessage());
//            return response($response, 403);
//        }
//
//        $response = $this->formatResponse('success', null);
//        return response($response, 204);
//    }

    protected function parseServices($services)
    {
        $parsedServices = [];

        foreach ($services as $serviceArray) {
            $parsedServices[] = end($serviceArray);
        }

        return $parsedServices;
    }
}
