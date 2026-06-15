<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\VerificationCodeMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::create($request->only('name', 'email', 'password'));

        Auth::login($user);

        $this->sendCode($user);

        return redirect()->route('verification.notice');
    }

    protected function sendCode(User $user): void
    {
        $code = $user->issueVerificationCode();

        Mail::to($user->email)->send(new VerificationCodeMail($code, $user->name));

        // In local development there is no real mailbox, so surface the code once.
        if (app()->environment('local')) {
            session()->flash('dev_code', $code);
        }
    }
}
