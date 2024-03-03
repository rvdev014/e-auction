<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Interfaces\MustVerifyPhone;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class EnsurePhoneIsNotVerified
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->isAdmin()) {
            return $next($request);
        }

        if ($user && ($user instanceof MustVerifyPhone && $user->hasVerifiedPhone())) {
            return redirect()->route(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
