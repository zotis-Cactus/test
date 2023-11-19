<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;

class LogController extends Controller
{
    public function index()
    {
        return view('content.logs.index');
    }
}
