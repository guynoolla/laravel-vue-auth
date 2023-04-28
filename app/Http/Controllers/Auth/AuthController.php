<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterFormRequest;
use App\Http\Requests\LoginFormRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AuthLog;
use App\DbLog\AuthDbLog;
use Session;
use Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function registration()
    {
        return view('auth.register');
    }

    public function postLogin(LoginFormRequest $request)
    {
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {

            $user = User::where('email', $request->email)->first();
            AuthDbLog::authSuccess($user);
            $request->session()->put('success', 'Авторизация прошла успешно!');

            return response()->json([
                "status" => true,
                "redirect" => url("dashboard")
            ]);

        } else {

            $errors["invalid_credentials"] = "Недействительные учётные данные";
            AuthDbLog::authFailed($errors);

            return response()->json([
                "status" => false,
                "errors" => $errors
            ]);
        }
    }

    public function postRegistration(RegisterFormRequest $request)
    {
        $user = $this->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        Auth::login($user);
        AuthDbLog::authSuccess($user);
        $request->session()->put('success', 'Отлично, регистрация завершена!');

        return response()->json([
            "status" => true,
            "redirect" => url("dashboard")
        ]);
    }

    public function dashboard(Request $request)
    {
        if (Auth::check()){
            $message = $request->session()->get('success');
            $request->session()->forget('success');
            return view('dashboard', ['success' => $message]);
        }

        return redirect("login")->withFail('Упс! у вас нет доступа.');
    }

    public function create(array $data)
    {
      return User::create([
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }

    public function logout() {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}
