<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Leeto\MoonShine\Http\Requests\LoginFormRequest;

class LoginController extends Controller
{

    public function login(LoginFormRequest $request): JsonResponse|Application|RedirectResponse|Redirector
    {
        $credentials = $request->only(['email', 'password']);
        $remember = $request->boolean('remember', false);

        if (auth('moonshine')->attempt($credentials, $remember)) {
            return response()->json();
        }

        return response()->json(['message' => 'Неправильный логин или пароль.'], 422);
    }
}
