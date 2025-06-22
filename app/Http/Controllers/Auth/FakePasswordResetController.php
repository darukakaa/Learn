<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;

class FakePasswordResetController extends Controller
{
    public function send(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // Buat token reset password
        $token = Password::createToken($user);

        // Redirect ke halaman reset password langsung
        return redirect()->route('password.reset', [
            'token' => $token,
            'email' => $user->email
        ]);
    }
}
