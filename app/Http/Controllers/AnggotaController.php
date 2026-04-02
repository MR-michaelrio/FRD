<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Regu;
use App\Models\User;
use App\Models\Wilayah;
use App\Models\Lembaga;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anggota = anggota::all()->where('role', '!=', 'anggota');
        return view('anggota.agt101&102', compact('anggota'));
    }

    public function index2()
    {
        $anggota = anggota::all();
        return view('anggota.agt2', compact('anggota'));
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
        anggota::create(array_filter($request->all(), function ($value) {
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
        $lmb = Lembaga::all();
        $regu = Regu::all();
        $wilayah = Wilayah::all();
        return view('anggota.edit', compact('data', 'regu', 'lmb', 'wilayah'));
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
        $user = User::where("id_anggota", $id)->first();
        // echo $request->wilayah;
        $agt->update([
            'nama' => $request->nama,
            'lembaga' => $request->lembaga,
            'email' => $request->email,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_pemegang' => $request->no_pemegang,
            'no_darurat1' => $request->no_darurat1,
            'nama_darurat1' => $request->nama_darurat1,
            'no_darurat2' => $request->no_darurat2,
            'nama_darurat2' => $request->nama_darurat2,
            'id_regu' => $request->id_regu,
            'role' => $request->role,
            'wilayah' => $request->wilayah
        ]);

        if ($request->role != "anggota" && $user) {
            $user->update([
                "level" => "supervisor" // pakai =>, bukan =
            ]);
        }
        else {
            $user->update([
                "level" => "basic" // pakai =>, bukan =
            ]);
        }
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
        $wilayah = Wilayah::where("status", "disetujui")->get();
        $lembaga = Lembaga::all();
        return view('anggota.daftar-anggota', compact('wilayah', 'lembaga'));
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
            'wilayah' => $request->wilayah
        ]);

        User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make('IR1234'),
            'level' => 'basic',
            'regu' => "0",
            'id_anggota' => $a->id_anggota,
            'wilayah' => $request->wilayah,
            'status' => "pending"
        ]);

        return redirect()->back()->with('success', 'User Sedang Dalam Pengajuan');
    }

    public function GantiPassword()
    {
        return view('auth.ganti-password');
    }

    public function UpdatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required'],
            'new_password_confirmation' => ['required', 'same:new_password'],
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal harus terdiri dari 8 karakter.',
            'new_password_confirmation.required' => 'Konfirmasi password baru wajib diisi.',
            'new_password_confirmation.same' => 'Konfirmasi password baru tidak sama dengan password baru.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('home');
    }

}