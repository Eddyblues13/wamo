<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class EmailVerificationController extends Controller
{
    public function notice(Request $request): View|RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('user.dashboard');
        }

        return view('auth.verify');
    }

    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'digits:4'],
        ]);

        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('user.dashboard');
        }

        if ($user->verification_attempts >= 5) {
            throw ValidationException::withMessages([
                'code' => 'Too many incorrect attempts. Please request a new code.',
            ]);
        }

        if ($user->verificationCodeExpired()) {
            throw ValidationException::withMessages([
                'code' => 'This code has expired. Please request a new one.',
            ]);
        }

        if (! $user->verificationCodeMatches($request->string('code'))) {
            $user->increment('verification_attempts');

            throw ValidationException::withMessages([
                'code' => 'The verification code is incorrect.',
            ]);
        }

        $user->markEmailVerified();

        return redirect()->route('user.dashboard')->with('status', 'Your email has been verified.');
    }

    public function resend(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('user.dashboard');
        }

        $key = 'resend-code:'.$user->id;

        if (RateLimiter::tooManyAttempts($key, 3)) {
            throw ValidationException::withMessages([
                'code' => 'Please wait '.RateLimiter::availableIn($key).' seconds before requesting another code.',
            ]);
        }

        RateLimiter::hit($key, 60);

        $code = $user->issueVerificationCode();

        Mail::to($user->email)->send(new VerificationCodeMail($code, $user->name));

        if (app()->environment('local')) {
            session()->flash('dev_code', $code);
        }

        return back()->with('status', 'A new verification code has been sent.');
    }
}
