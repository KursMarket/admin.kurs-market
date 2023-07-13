<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    const PATH = 'dashboard.';

    public function index()
    {
        return view(self::PATH . 'index');
    }
}
