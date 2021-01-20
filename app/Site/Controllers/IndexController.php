<?php


namespace App\Site\Controllers;

use App\Core\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function home()
    {
        return view('site.home');
    }
}
