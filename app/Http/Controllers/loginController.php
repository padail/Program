<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class loginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'user_name'=>'required',
            'password'=>'required'
        ]);
        if (Auth::attempt(['user_name'=>$request->user_name,'password'=>$request->password, 'level'=>'admin'])){
            return redirect('/admin');
        }
        elseif (Auth::attempt(['user_name'=>$request->user_name,'password'=>$request->password, 'level'=>'user'])){
            return redirect('/dashboard');
        }
        else {
            return redirect('/');
        }
    }
    public function logout(){
        Auth::logout();
        return redirect('/');
    }
    public function daftar(Request $request){
        $data = User::updateOrCreate(['id'=>$request->id],[
            'user_name'=>$request->user_name,
            'password'=>$request->password,
            'level'=>$request->level
        ]);
        return response()->json($data);
    }
}
