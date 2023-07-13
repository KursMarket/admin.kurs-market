<?php


namespace App\Services;


use App\Services\Interfaces\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthServiceImpl implements AuthService
{
    /**
     * @override
     * @return void
     */
    public function logout(): void
    {
        Session::flush();
        Auth::logout();
    }
}
