<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $type = $request->string('type')->toString();

        $transactions = Transaction::with('user')
            ->when($type, fn ($q) => $q->where('type', $type))
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('admin.transactions.index', compact('transactions', 'type'));
    }
}
