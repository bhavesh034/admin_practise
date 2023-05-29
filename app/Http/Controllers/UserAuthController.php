<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Roles;
use Session;
use Hash;
use Illuminate\Support\Facades\DB;


class UserAuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $login = $request->only('email', 'password');
        if (Auth::attempt($login) && Auth::user()->roles_id == 1) {
            Session::put('login_user_role', 'admin');
            return redirect()->route('admin.dashboard');
        } elseif (Auth::attempt($login) && Auth::user()->roles_id == 2) {
            Session::put('login_user_role', 'production');
            return redirect()->route('production.dashboard');
        } elseif (Auth::attempt($login) && Auth::user()->roles_id == 3) {
            Session::put('login_user_role', 'dispatch');
            return redirect()->route('dispatch.dashboard');
        } else {
            return redirect("login")->withSuccess('Login details are not valid');
        }
    }
    public function user()
    {
        $roles = DB::table('roles')->get();
        return view('auth.registration', ["roles" => $roles]);
    }
    public function signout()
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'roles_id' => 'required',
        ]);

        $data = $request->all();

        $check = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'roles_id' => $data['roles_id']
        ]);

        return redirect("/dashboard")->withSuccess('You have signed-in');
    }
    public function dashboard()
    {
        if (Auth::check()) {
            return view('dashboard');
        }
        return redirect("/")->withSuccess('You are not allowed to access');
    }
    public function home()
    {
        return view('index');
    }
}
