<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\anggota;
use App\Models\Regu;
use App\Models\User;

use Carbon\Carbon;
use DB;
use App\Services\FirebaseNotificationService;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tanggal = Carbon::now()->format('d-m-Y');

        $tiket = Laporan::where('tanggal', $tanggal)
                ->orwhere('status', 'aktif')
                ->orderBy('status', 'asc')
                ->get();

        $damkar = DB::table('damkar_65')
            ->whereRaw("DATE(tanggal) = ?", [Carbon::now()->format('Y-m-d')])
            ->get();

        return view('laporan.index',compact('tiket','damkar'));
    }

    public function rekap()
    {
        $tiket = Laporan::orderBy('status', 'asc')
                ->get();

        $damkar = DB::table('damkar_65')->get();

        return view('laporan.rekap',compact('tiket','damkar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('laporan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, FirebaseNotificationService $fcm)
    {
        //
        \Log::info('MASUK STORE LAPORAN');
        $names = Anggota::where('id_regu', auth()->user()->regu)->pluck('nama')->toArray();
        $petugas_piket = implode(', ', $names);
        $regu = Regu::where('id_regu', auth()->user()->regu)->pluck('nama_regu')->first();
        $nama_petugas = auth()->user()->name;
        $kejadian = Laporan::create(array_merge([
            'regu' => $regu,
            'petugas_piket' => $petugas_piket,
            'nama_petugas' => $nama_petugas
        ], $request->all()));  

        $users = User::whereNotNull('fcm_token')->get();

        foreach ($users as $user) {
            try {
                $fcm->send(
                    $user->fcm_token,
                    '🚨 Laporan Baru',
                    'Ada laporan baru dari regu ' . $regu
                );
            } catch (\Throwable $e) {
                // ❗ jangan gagalkan store kalau notif gagal
                \Log::error('FCM Error: ' . $e->getMessage());
            }
        }
        // Convert the laporans collection to an array
        // $laporansArray = $kejadian->toArray();

        // Encode the array to a JSON format for URL safety
        // $encodedLaporans = urlencode(json_encode($laporansArray));

        // $redirectUrl = 'http://101.255.101.60:3000/laporan?status=' . 'aktif' . '&kejadian=' . $encodedLaporans;
        // return redirect($redirectUrl);
        return redirect()->route("lpr.index");
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
        $a = Laporan::find($id);
        return view('laporan.edit',compact('a'));
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
        $laporan = Laporan::find($id);
        $laporan->update($request->all());
        // Convert the laporans collection to an array
        $laporan->refresh();

        $laporansArray = $laporan->toArray();

        // Encode the array to a JSON format for URL safety
        $encodedLaporans = urlencode(json_encode($laporansArray));
        $redirectUrl = 'http://101.255.101.60:3000/updatelaporan?tanggal_kejadian=' . Carbon::yesterday() . '&kejadian=' . $encodedLaporans;
        return redirect($redirectUrl);
    }

    public function selesai(Request $request, $id)
    {
        //
        $laporan = Laporan::where('id_kejadian', $id)->first();

        $laporan->update([
            'kejadian'=>$request->kejadian,
            'objek'=>$request->objek,
            'tanggal'=>$request->tanggal,
            'terima_berita'=>$request->terima_berita,
            'situasi'=>$request->situasi,
            'pengerahan_akhir'=>$request->pengerahan_akhir,
            'alamat'=>$request->alamat,
            'responder'=>$request->responder,
            'status'=>"selesai",
            'waktu_selesai'=>$request->waktu_selesai
        ]);
        $laporan->refresh();

        $laporansArray = $laporan->toArray();

        // Encode the array to a JSON format for URL safety
        $encodedLaporans = urlencode(json_encode($laporansArray));
        $redirectUrl = 'http://101.255.101.60:3000/updatelaporan?tanggal_kejadian=' . Carbon::yesterday() . '&kejadian=' . $encodedLaporans;
        return redirect($redirectUrl);
    }

    public function search(Request $request)
    {
        // Get the search query from the request
        $tanggal = $request->input('table_search');
        $inputDate = date('Y-d-m', strtotime(str_replace('-', '/', $tanggal)));

        if($tanggal == ''){
            $tiket = Laporan::where('tanggal', Carbon::now()->format('d-m-Y'))->orderBy('status', 'asc')->get();
            $damkar = DB::table('damkar_65')
                ->whereRaw("DATE(tanggal) = ?", [Carbon::now()->format('Y-m-d')])
                ->get();
        }else{
            $tiket = Laporan::where('tanggal',$tanggal)->get();
            $damkar = DB::table('damkar_65')
                ->whereRaw("DATE(tanggal) = ?", $inputDate)
                ->get();
        }

        return view('laporan.index',compact('tiket','damkar'));

    }

    public function searchrekap(Request $request)
    {
        // Get the search query from the request
        $tanggal = $request->input('table_search');
        $inputDate = date('Y-d-m', strtotime(str_replace('-', '/', $tanggal)));

        if($tanggal == ''){
            $tiket = Laporan::orderBy('status', 'asc')->get();
            $damkar = DB::table('damkar_65')->get();
        }else{
            $tiket = Laporan::where('tanggal',$tanggal)->get();
            $damkar = DB::table('damkar_65')
                ->whereRaw("DATE(tanggal) = ?", $inputDate)
                ->get();
        }

        return view('laporan.rekap',compact('tiket','damkar'));

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $laporan = Laporan::where('id_kejadian', $id)->first(); // Menggunakan first() untuk mendapatkan satu model
        if($laporan) {
            $laporan->delete(); // Menghapus record yang cocok
        }
        return redirect()->route('lpr.index');
    }

}
