<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
 public function __construct() {
     $this->middleware('guest')->except('logout');
 }

 // Форма входа в личный кабинет
 public function login() {
     //dd('тест');
     return view('auth.login');
 }

 // Аутентификация пользователя
 public function authenticate(Request $request) {
     $credentials = $request->validate([
         'email' => 'required|string|email',
         'password' => 'required|string',
     ]);

     //$credentials = $request->only('email', 'password');

     if (Auth::attempt($credentials, $request->has('remember'))) {
        if (is_null(Auth::user()->email_verified_at)){
            Auth::logout();
            return redirect()
                ->route('auth.vefiry-message')
                ->withErrors('Адрес почты не подтвержден');
        }

         return redirect()
             ->route('user.index')
             ->with('success', 'Вы вошли в личный кабинет.');
     }

     return redirect()
         ->route('auth.login')
         ->withErrors('Неверный логин или пароль!');

 }

 // Выход из личного кабинета
 public function logout() {
     Auth::logout();
     return redirect()->route('index')
         ->with('success', 'Вы вышли из личного кабинета');
 }
}
