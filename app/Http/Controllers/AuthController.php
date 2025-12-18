<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email ou senha inválidos.',
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $request->validate([
            'name' => ['required'],
            'cpf' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6',],
        ]);

        $cpf = preg_replace('/\D/', '', $request->cpf);

        $cpfsAutorizados = config('cpfs.autorizados');

        if (!in_array($cpf, $cpfsAutorizados)) {
            throw ValidationException::withMessages([
                'cpf' => 'Este CPF não está autorizado a criar uma conta.',
            ]);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'cpf' => $request->cpf
        ]);

        return redirect()->route('login')->with('success', 'Conta criada com sucesso!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
