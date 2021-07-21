<?php
/**
 * File UserController.php
 *
 * @author Tuan Duong <bacduong@gmail.com>
 * @package Laravue
 * @version 1.0
 */

namespace App\Portal\Controllers\Api;

use App\Http\Resources\BalanceHistoryResource;
use App\Http\Resources\CityResource;
use App\Portal\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\Api
 */
class BalanceHistoryController extends BaseController
{
    const ITEM_PER_PAGE = 10;

    /**
     * Display a listing of the payments resource.
     *
     * @param Request $request
     * @return Response|ResourceCollection
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $limit = Arr::get($request->all(), 'limit', static::ITEM_PER_PAGE);
        $payments = $user->balanceHistories()->paginate($limit);

        return BalanceHistoryResource::collection($payments);
    }
}
