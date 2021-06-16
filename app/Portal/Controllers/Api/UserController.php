<?php
/**
 * File UserController.php
 *
 * @author Tuan Duong <bacduong@gmail.com>
 * @package Laravue
 * @version 1.0
 */

namespace App\Portal\Controllers\Api;

use App\Core\Traits\FormatResponse;
use App\Http\Resources\MasterResource;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\UserResource;
use App\Portal\Helpers\Acl;
use App\Portal\Models\Permission;
use App\Portal\Models\Role;
use App\Portal\Models\Setting;
use App\Portal\Models\User;
use App\Portal\User\Requests\CreateRequest;
use App\Portal\User\Requests\UpdateRequest;
use App\Portal\User\Requests\UploadAvatarRequest;
use App\Portal\User\Requests\UserRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Validator;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\Api
 */
class UserController extends BaseController
{
    use FormatResponse;

    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the user resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|ResourceCollection
     */
    public function index(Request $request)
    {
        $auth_user = Auth::user();
        $searchParams = $request->all();
        $userQuery = User::query();
        $limit = Arr::get($searchParams, 'limit', static::ITEM_PER_PAGE);
        $role = Arr::get($searchParams, 'role', '');
        $keyword = Arr::get($searchParams, 'keyword', '');

        if ($auth_user->hasRole('manager')) {
            $role = 'master';
        }

        if (!empty($role)) {
            $userQuery->whereHas('roles', function($q) use ($role) {
                $q->where('name', $role);
            });
        }

        if (!empty($keyword)) {
            $userQuery->whereRaw("concat(first_name, ' ', last_name) like '%$keyword%'");
            $userQuery->orWhere('email', 'LIKE', '%' . $keyword . '%');
        }

        return UserResource::collection($userQuery->paginate($limit));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return UserResource
     */
    public function store(CreateRequest $request)
    {
        $params = $request->all();
        $user = User::create([
            'first_name' => $params['first_name'],
            'last_name' => $params['last_name'],
            'email' => $params['email'],
            'password' => Hash::make($params['password']),
        ]);
        $role = Role::findByName($params['role']);
        $user->syncRoles($role);

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @param UserRequest $request
     * @return MasterResource|UserResource
     */
    public function show(User $user, UserRequest $request)
    {
        if ($user->hasRole('master')) {
            return new MasterResource($user);
        } else {
            return new UserResource($user);
        }
    }

    public function showCurrentUser(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('master')) {
            return new MasterResource($user);
        } else {
            return new UserResource($user);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param User $user
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, User $user)
    {
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'date_of_birth' => Carbon::parse($request->date_of_birth)->format('Y-m-d'),
            'about' => $request->about,
        ]);

        if ($user->hasRole('master')) {
            $user->skills()->sync($request->skills);
        }

        return response()->json(['success' => true], 201);
    }

    /**
     * Upload avatar.
     *
     * @param UploadAvatarRequest $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function uploadAvatar(UploadAvatarRequest $request, User $user)
    {
        $photo = $request->avatar;

        $name = uniqid($user->id . '_') . "." . $photo->getClientOriginalExtension();
        Storage::putFileAs('/public/uploads/avatars/' . $user->id . '/', $photo, $name);

        $link = Storage::url('uploads/avatars/' . $user->id . '/' . $name);

        $user->update(['avatar' => $link]);

        $response = $this->formatResponse('success', null, $link);
        return response($response, 201);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserRequest $request, User $user)
    {
        try {
            $user->delete();
        } catch (\Exception $ex) {
            $response = $this->formatResponse('error', $ex->getMessage());
            return response($response, 403);
        }

        $response = $this->formatResponse('success', null);
        return response($response, 204);
    }


    public function setLanguage(Request $request)
    {
        $authUser = Auth::user();

        if ($authUser !== null) {
            $langSetting = Setting::title('language')->first();
            $authUser->settings()->syncWithoutDetaching([$langSetting->id => ['value' => $request->lang]]);

            Cache::forget('language');
        }

        $response = $this->formatResponse('success', null);
        return response($response, 200);
    }

    public function listMasters()
    {
        return UserResource::collection(User::role('master')->get());
    }
}
