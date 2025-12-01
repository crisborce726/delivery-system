<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('web')->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login as a user.');
        }

        // Redirect if email is not verified
        if (!$user->is_verified || is_null($user->verified_at)) {
            return redirect()->route('otp.verify.show')
                ->with('error', '📧 Please verify your email address first. Check your email for OTP code.');
        }

        return $next($request);
    }
}
