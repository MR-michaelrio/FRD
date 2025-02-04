<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\anggota;
use App\Models\Regu;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anggota = anggota::all()->where('role','!=','anggota');
        return view('anggota.agt101&102',compact('anggota'));
    }

    public function index2()
    {
        $anggota = anggota::all();
        return view('anggota.agt2',compact('anggota'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regu = Regu::all();
        return view('anggota.create', compact('regu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        anggota::create(array_filter($request->all(), function($value) {
            return !is_null($value);
        }));
        
        return redirect()->route('agt.index2');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = anggota::findorFail($id);
        $regu = Regu::all();
        return view('anggota.edit', compact('data','regu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $agt = anggota::find($id);
// echo $request->wilayah;
        $agt->update([
            'nama'=>$request->nama,
            'lembaga'=>$request->lembaga,
            'email'=>$request->email,
            'tanggal_lahir'=>$request->tanggal_lahir,
            'jenis_kelamin'=>$request->jenis_kelamin,
            'alamat'=>$request->alamat,
            'no_pemegang'=>$request->no_pemegang,
            'no_darurat1'=>$request->no_darurat1,
            'nama_darurat1'=>$request->nama_darurat1,
            'no_darurat2'=>$request->no_darurat2,
            'nama_darurat2'=>$request->nama_darurat2,
            'id_regu'=>$request->id_regu,
            'role'=>$request->role,
            'wilayah'=>$request->wilayah
            
        ]);
        // echo $agt;
        return redirect()->route('agt.index2');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $agt = anggota::find($id);
        $agt->delete();
        return redirect()->route('agt.index2');
    }

    public function indexdaftar()
    {
        return view('daftar-anggota');
    }

    public function daftar(Request $request)
    {
        $a = anggota::create([
            'nama' => $request->nama,
            'lembaga' => $request->lembaga,
            'no_pemegang' => $request->no_pemegang,
            'alamat' => $request->alamat,
            'no_darurat1' => $request->no_darurat1,
            'nama_darurat1' => $request->nama_darurat1,
            'no_darurat2' => $request->no_darurat2,
            'nama_darurat2' => $request->nama_darurat2,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make('IR1234'),
            'level' => 'anggota',
            'regu' => "0",
            'id_anggota' => $a->id_anggota
        ]);

        return redirect()->route('daftar-anggota')->with('success', 'Data Berhasil Ditambahkan');
    }
}
