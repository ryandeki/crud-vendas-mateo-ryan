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
                'text_username' => 'required',
                'text_password' => 'required|min:6|max:16'
            ],
            [
                'text_username.required' => 'O campo do e-mail é obrigatório.',

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

    public function signin()
    {
        return view('signin');
    }

    public function signinSubmit(Request $request)
    {
        $request->validate([
            'text_username' => 'required|min:3|max:50|unique:users,username',
            'text_email' => 'required|email|max:80|unique:users,email',
            'text_password' => 'required|min:6|max:16',
        ], [
            'text_username.required' => 'O nome de usuário é obrigatório',
            'text_username.min' => 'O nome de usuário deve conter no mínimo :min caracteres',
            'text_username.max' => 'O nome de usuário deve conter no máximo :max caracteres',
            'text_username.unique' => 'Esse nome de usuário não está disponível',

            'text_email.required' => 'O campo de e-mail é obrigatório',
            'text_email.email' => 'O e-mail deve conter um endereço válido.',
            'text_email.max' => 'O e-mail deve conter no máximo :max caracteres',
            'text_email.unique' => 'Esse e-mail já está sendo utilizado',

            'text_password.required' => 'O campo de senha é obrigatório',
            'text_password.min' => 'A senha deve conter no mínimo :min caracteres',
            'text_password.max' => 'A senha deve conter no máximo :max caracteres',
        ]);

        $user = new User();
        $user->username = $request->text_username;
        $user->email = $request->text_email;
        $user->senha = bcrypt($request->text_password);
        $user->save();

        return redirect()->route('login')->with('signin_success', 'Registro feito com sucesso. Você já pode fazer o login');
    }

    public function logout()
    {
        session()->forget('user');

        return redirect()->route('login');
    }
}