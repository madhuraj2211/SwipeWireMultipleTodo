<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    //
    public function signup(SignupRequest $request){
        $data = $request->validated();

        /** @var \App\Models\User $user */
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        return redirect('/login');
    }


    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'message' => 'Provided email or password is incorrect'
            ])->withInput();
        }
    
        $user = Auth::user();
        session()->put('user', $user);
        return redirect()->route('todolist.index');
    }

    public function logout(){
        Auth::logout();
        Session::forget('user');
        return redirect('/login');
    }
}
