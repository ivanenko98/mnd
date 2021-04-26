<?php


namespace App\Portal\Controllers;

use App\Core\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('portal.template');
    }
}
