<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Newsletter;

class SubscribeController extends Controller
{
    public function index()
    {
        return view('subscribe');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required'
        ]);

        if (!Newsletter::isSubscribed($request->email)) {
            Newsletter::subscribe($request->email);
            return back()->with('flash', 'شما الان اشتراک خبر نامه دارید.');
        } else {
            return back()->with('failure', 'شما از قبل اشتراک دارید');
        }

    }
}
