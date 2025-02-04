<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wilayah;
use App\Models\anggota;
use Illuminate\Support\Facades\Log;

class WilayahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wilayah = Wilayah::all();
        $supervisors = anggota::all();
        return view("wilayah.index", compact("wilayah", "supervisors"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("wilayah.daftar-wilayah");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Wilayah::create([
            "nama_wilayah" => $request->nama_wilayah,
            "status" => "menunggu persetujuan"
        ]);

        return redirect()->route('daftar-wilayah')->with('success', 'Wilayah Baru Sedang Dalam Pengajuan');
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
        // Temukan wilayah berdasarkan ID
        $wilayah = Wilayah::where('id_wilayah',$id)->first();
        Log::info('Updating supervisor to: ' . $request->supervisor);

        // Menangani logika pembaruan berdasarkan field yang diterima
        if ($request->has('status')) {
            // Jika status yang diterima, perbarui status
            Log::info('Updating status to: ' . $request->status);
            $wilayah->status = $request->status;
        }

        if ($request->has('supervisor')) {
            // Jika supervisor yang diterima, perbarui supervisor
            Log::info('Updating supervisor to: ' . $request->supervisor);
            $wilayah->supervisor = $request->supervisor;
        }

        if ($request->has('nama_wilayah')) {
            Log::info('Updating nama wilayah to: ' . $request->nama_wilayah);
            $wilayah->nama_wilayah = $request->nama_wilayah;
        }
        
        // Simpan perubahan ke database
        $wilayah->save();

        return response()->json([
            'success' => true,
            'message' => $request->supervisor, // Pesan berhasil yang dikembalikan
            'data' => $wilayah // Menampilkan data wilayah yang baru diperbarui
        ]);
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
