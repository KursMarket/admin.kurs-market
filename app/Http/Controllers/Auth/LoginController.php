<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\AuthService;
use App\Services\Response\ResponseService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    const PATH = 'auth.';

    /**
     * LoginController constructor.
     * @param AuthService $authService
     */
    public function __construct(
        private AuthService $authService
    ) {}

    public function loginView(): Factory|View|Application
    {
        return view(self::PATH . 'login');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws AuthException
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);
        if (!Auth::attempt($credentials, $request->has('remember'))) {
            throw new AuthException('Неправильный логин и/или пароль');
        }

        return ResponseService::sendJsonResponse(true, 200, null, ['redirect' => route('dashboard.index')]);
    }

    public function logout(): RedirectResponse
    {
        $this->authService->logout();
        return redirect()->route('login');
    }
}
