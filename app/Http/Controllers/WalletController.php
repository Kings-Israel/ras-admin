<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\WalletTransaction;

class WalletController extends Controller
{
    public function index()
    {
        $wallet_balance = 0;

        if (auth()->user()->hasRole('admin')) {
            
        }

    }
}
