<?php

namespace App\Http\Controllers;

use http\Exception;
use Illuminate\Http\Request;

class SessionsController extends Controller
{

    public function create()
    {
        return view('sessions.login');
    }
    public function destroy()
    {
        auth()->logout();

        return redirect('/')->with('success', 'You have been logout successfully!');
    }

    public function store()
    {
        $attributes = \request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // attempt to login
        if (! auth()->attempt($attributes)) {

            // auth failed
            return back()
                ->withInput() // return input data back
                ->withErrors(['email' => 'Your provided credentials could not be verified.']);
        }

        // session fixation
        session()->regenerate();
        // redirect with success message
        return redirect('/')->with('success', 'Welcome back');
    }
}
