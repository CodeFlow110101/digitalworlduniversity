<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function fail(Request $request)
    {
        session()->flash('transaction', $request->all());
        return redirect()->route('join-failure');
    }

    public function success(Request $request)
    {
        session()->flash('transaction', $request->all());
        return redirect()->route('join-success');
    }
}
