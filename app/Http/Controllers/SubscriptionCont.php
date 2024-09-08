<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionCont extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['email' => 'required|email|unique:subscriptions,email']);

        Subscription::create(['email' => $request->email]);

        return back()->with('success', 'You have successfully subscribed.');
    }
}
