<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class userController extends Controller
{
    public function addUser(Request $request)
    {
        $data = User::updateOrCreate(['id'=>$request->id],[
            'user_name'=>$request->username,
            'password'=>bcrypt($request->password),
            'level'=>$request->level
        ]);
        return response()->json($data);
    }
    public function getUser($level)
    {
        if($level!='semua'){
            $data = User::where('level','like','%'.$level.'%')->get();
            // Mobil::where('jenis','like','%'.$jenis.'%')->latest()->get();
        }
        else{
            $data = User::latest()->get();
        }
        return response()->json($data);
    }
    public function getName(){
        $data = DB::table('users')->select('user_name')->get();
        return response()->json($data);
    }
    public function editUser($id)
    {
        $data = User::where('id',$id)->first();
        // dd($data);
        return response()->json($data);
    }
    public function deleteUser($id){
        if ($id) {
            $data = User::find($id);
            $data->delete();
        }
        return response()->json($data);
    }
}
