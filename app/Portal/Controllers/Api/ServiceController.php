<?php
/**
 * File UserController.php
 *
 * @author Tuan Duong <bacduong@gmail.com>
 * @package Laravue
 * @version 1.0
 */

namespace App\Portal\Controllers\Api;

use App\Http\Resources\ServiceResource;
use App\Portal\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\Api
 */
class ServiceController extends BaseController
{
    /**
     * Display a listing of the user resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|ResourceCollection
     */
    public function index(Request $request)
    {
        $services = Service::where('parent_id', null)->get();

        return ServiceResource::collection($services);
    }
}
