<?php

namespace App\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class LogoutController extends Controller
{

    /**
     * @return Redirector|Application|RedirectResponse
     */
    public function perform(): Redirector|Application|RedirectResponse
    {
        session()->flush();
        auth('moonshine')->logout();
        return redirect('/');
    }
}
