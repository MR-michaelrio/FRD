<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lembaga;

class LembagaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lembaga = Lembaga::all();
        return view("lembaga.index", compact("lembaga"));
    }

    public function indexdaftar()
    {
        return view("lembaga.daftar-lembaga");
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lembaga' => 'required|string|max:255',
            'logo_lembaga' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Maks 2MB
        ]);

        // Simpan logo jika ada
        if ($request->hasFile('logo_lembaga')) {
            $file = $request->file('logo_lembaga');
            $filename = time() . '_' . $file->getClientOriginalName(); // Buat nama unik
            $file->move(public_path('lembaga'), $filename); // Simpan ke public/logos
            $logoPath = 'lembaga/' . $filename; // Path untuk disimpan di database
        } else {
            $logoPath = null;
        }

        // Simpan data ke database
        Lembaga::create([
            'nama_lembaga' => $request->nama_lembaga,
            'logo_lembaga' => $logoPath,
        ]);

        return redirect()->back()->with('success', 'Lembaga Berhasil Didaftarkan!');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
