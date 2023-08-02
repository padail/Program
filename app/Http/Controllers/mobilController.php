<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class mobilController extends Controller
{
    public function addMobil(Request $request){
        $gambar = $request->file('gambar')->store('gambar','public');
        $data = Mobil::updateOrCreate(['id'=>$request->id],[
            'nama'          =>$request->nama,
            'jenis'         =>$request->jenis,
            'bahan_bakar'   =>$request->bahan_bakar,
            'gambar'        =>$gambar,
            'harga'         =>$request->harga,
            'jumlah_kursi'  =>$request->jumlah_kursi,
            'status'        =>$request->status
        ]);

        return back();
    }

    public function detailMobil(){
        $data = DB::table('users')
                ->rightJoin('mobils','id_user','=','users.id')
                ->where('level','user')
                ->get();
        return response()->json($data); 
    }

    public function getMobil($jenis = 'semua'){
        // dd($jenis);
        if ($jenis!='semua') {
            $data = Mobil::where('jenis',$jenis)->latest()->get();
        }
        else{
            $data = Mobil::latest()->get();
        }
        return response()->json($data);
    }
    public function editMobil($id){
        $data = Mobil::where('id',$id)->first();
            // dd($data);
        return response()->json($data);
    }
    public function deleteMobil($id){
        if($id){
            $del = Mobil::find($id);
            $del->delete();
        }
        return response()->json($del);
    }
    public function addUlasanMobil(Request $request){
        $data = Ulasan::updateOrCreate(['id'=>$request->id],[
            'nama' =>$request->nama,
            'id_mobil'=> $request->id_mobil,
            'rate'=> $request->rate,
            'ulasan'=> $request->ulasan
        ]);
        // dd($request);
        return response()->json($data);
    }

    public function getUlasan($id){
            $get = Ulasan::where('id_mobil',$id)->get();
            // dd($get);
            return response()->json($get);
    }

}
