<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create(){
        return Inertia::render('Login');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'login' => 'required|string',
            'password' => 'required|min:6',
        ]);

        $fieldType = filter_var($validated['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $fieldType => $validated['login'],
            'password' => $validated['password'],
        ];

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()
            ->route('dashboard')
            ->with('success', 'Welcome back to NibbleNotes!');

        }

        throw ValidationException::withMessages([
            'login' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
