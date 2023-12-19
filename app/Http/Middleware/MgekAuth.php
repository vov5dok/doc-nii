<?php

namespace App\Http\Middleware;

use App\Models\MoonshineUser;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MgekAuth
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $redirectMainPage = auth('moonshine')->guest()
            || auth('moonshine')->user()->active !== MoonshineUser::IS_ACTIVE
            || auth('moonshine')->user()->verify_token != null;
        if ($redirectMainPage) {
            return redirect()->guest(route('home'));
        }
        return $next($request);
    }


}
