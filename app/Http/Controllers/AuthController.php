<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        $request->validate(
            [
                'text_username' => 'required|email',
                'text_password' => 'required|min:6|max:16'
            ],
            [
                'text_username.required' => 'O campo do e-mail é obrigatório.',
                'text_username.email' => 'O campo de e-mail deve conter um endereço válido.',

                'text_password.required' => 'A senha é obrigatória.',
                'text_password.min' => 'A senha deve conter no mínimo :min caracteres.',
                'text_password.max' => 'A senha deve conter no máximo :max caracteres.',
            ]
        );

        $username = $request->input('text_username');
        $password = $request->input('text_password');


        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            echo 'A conexão falhou: ' . $e->getMessage();
        }

        $user = User::where('username', $username)->whereNull('deleted_at')->first();
        if (!$user) {
            return redirect()->back()->withInput()->with('login_error', 'Username ou senha incorretos.');
        }

        if (!password_verify($password, $user->senha)) {
            return redirect()->back()->withInput()->with('login_error', 'Username ou senha incorretos.');
        }

        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
            ]
        ]);

        return redirect()->route('home');
    }

    public function logout()
    {
        session()->forget('user');

        return redirect()->route('login');
    }
}
