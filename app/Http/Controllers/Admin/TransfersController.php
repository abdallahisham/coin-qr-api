<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Transfer;
use App\Http\Controllers\Controller;

class TransfersController extends Controller
{
    public function index()
    {
        $transfers = Transfer::with(['sender', 'receiver'])->orderByDesc('created_at')->get();
        return view('admin.transfers.index', compact('transfers'));
    }

    public function confirm(Transfer $transfer)
    {
        $receiver = User::find($transfer->receiver_id);
        $receiver->suspended_balance -= $transfer->amount;
        $receiver->balance += $transfer->amount;
        $receiver->save();
        
        $transfer->status = 1;
        $transfer->save();

        flash('Confirmed successfully')->success();

        return redirect()->route('transfers');
    }
}
