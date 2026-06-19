<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NotificationMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BroadcastController extends Controller
{
    public function create(): View
    {
        return view('admin.broadcast.index', [
            'totalUsers' => User::count(),
            'verifiedUsers' => User::whereNotNull('email_verified_at')->count(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'audience' => ['required', 'in:all,verified,unverified'],
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:10000'],
        ]);

        $lines = preg_split('/\r\n|\r|\n/', $validated['message']) ?: [$validated['message']];

        $query = User::query()
            ->when($validated['audience'] === 'verified', fn ($q) => $q->whereNotNull('email_verified_at'))
            ->when($validated['audience'] === 'unverified', fn ($q) => $q->whereNull('email_verified_at'));

        $sent = 0;
        $query->select(['id', 'name', 'email'])->chunkById(200, function ($users) use (&$sent, $validated, $lines): void {
            foreach ($users as $user) {
                NotificationMail::deliver($user, $validated['subject'], $validated['subject'], $lines);
                $sent++;
            }
        });

        return redirect()->route('admin.broadcast.create')
            ->with('status', "Email queued to {$sent} user(s).");
    }
}
