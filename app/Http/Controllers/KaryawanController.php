<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $data = Karyawan::where('nama','LIKE','%'.$request->search.'%')
                            ->orwhere('jeniskelamin','LIKE','%'.$request->search.'%')
                            ->orwhere('notelepon','LIKE','%'.$request->search.'%')
                            ->paginate(5)->withQueryString();
        }else{
            $data = Karyawan::paginate(5);
        }
        return view('datakaryawan', compact('data'));
        // tampil data aja
        // $data = Karyawan::paginate(5);
        // return view('datakaryawan', compact('data'));
    }

    public function tambahkaryawan()
    {
        return view('tambahkaryawan');
    }

    public function insertdata(Request $request)
    {
        // dd($request->all());
        $data = Karyawan::create($request->all());
        if ($request->hasFile('foto')) {
            $request->file('foto')->move('fotopegawai/', $request->file('foto')->getClientOriginalName());
            $data->foto = $request->file('foto')->getClientOriginalName();
            $data->save();
        }
        return redirect()->route('karyawan')->with('success', 'Data berhasil ditambahkan');
    }

    public function tampildata($id)
    {
        $data = Karyawan::find($id);
        // dd($data);
        return view('tampildata', compact('data'));
    }

    public function updatedata(Request $request, $id)
    {
        $data = Karyawan::find($id);
        $data->update($request->all());
        return redirect()->route('karyawan')->with('success', 'Data berhasil di Update');
    }

    public function delete($id)
    {
        $data = Karyawan::find($id);
        $data->delete();
        return redirect()->route('karyawan')->with('success', 'Data berhasil di Delete');
    }
}
