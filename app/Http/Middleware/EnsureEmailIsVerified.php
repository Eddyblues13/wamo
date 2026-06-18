<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    /**
     * Ensure the authenticated user has verified their email (via the 4-digit code)
     * and is not blocked. Admin impersonation bypasses the verification gate.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $impersonating = $request->session()->has('impersonator_admin_id');

        // Suspended accounts are signed out (unless an admin is impersonating).
        if ($user && method_exists($user, 'isBlocked') && $user->isBlocked() && ! $impersonating) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'Your account has been suspended. Please contact support.',
            ]);
        }

        if ($impersonating) {
            return $next($request);
        }

        if (! $user instanceof MustVerifyEmail || ! $user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
