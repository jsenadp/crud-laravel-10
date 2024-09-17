<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;

class KaryawanController extends Controller
{
    public function index(){

        $data = Karyawan::all();
        return view('datakaryawan', compact('data'));
    }

    public function tambahkaryawan(){
        return view('tambahkaryawan');
    }

    public function insertdata(Request $request){
        // dd($request->all());
        $data = Karyawan::create($request->all());
        if($request->hasFile('foto')){
            $request->file('foto')->move('fotopegawai/', $request->file('foto')->getClientOriginalName());
            $data->foto = $request->file('foto')->getClientOriginalName();
            $data->save();
        }
        return redirect()->route('karyawan')->with('succes', 'Data berhasil ditambahkan');
    }

    public function tampildata($id){
        $data = Karyawan::find($id);
        // dd($data);
        return view('tampildata', compact('data'));
    }

    public function updatedata(Request $request, $id){
        $data = Karyawan::find($id);
        $data->update($request->all());
        return redirect()->route('karyawan')->with('succes', 'Data berhasil di Update');
    }

    public function delete($id){
        $data = Karyawan::find($id);
        $data->delete();
        return redirect()->route('karyawan')->with('succes', 'Data berhasil di Delete');
    }
}

