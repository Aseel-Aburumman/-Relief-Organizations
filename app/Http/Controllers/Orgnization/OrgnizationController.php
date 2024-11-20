<?php

namespace App\Http\Controllers\Orgnization;

use App\Http\Controllers\Controller;

class OrgnizationController extends Controller
{


    public function dashboard()
    {
        return view('orgnization.dashboard');
    }
}
