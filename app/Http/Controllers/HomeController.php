<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\anggota;
use App\Models\Laporan;
use Carbon\Carbon;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $jmlhanggota = anggota::all()->count();
        
        $tanggal = Carbon::now()->format('d-m-Y');

        // $tiket = Laporan::where('tanggal', $tanggal)
        //         ->orwhere('status', 'aktif')
        //         ->whereRaw("DATE(tanggal) = ?", [Carbon::now()->format('Y-m-d')])
        //         ->orderBy('status', 'asc')
        //         ->get();

                $tiket = Laporan::where(function ($query) use ($tanggal) {
        $query->whereDate('tanggal', $tanggal)
              ->orWhere('status', 'aktif');
    })
    ->whereDate('tanggal', [Carbon::now()->format('d')])
    ->orderBy('status', 'asc')
    ->get();


        return view('template.master',compact('jmlhanggota','tiket'));
    }

    public function saveToken(Request $request)
    {
        \Log::info('SAVE TOKEN MASUK', [
            'user_id' => auth()->id(),
            'token' => substr($request->token, 0, 20)
        ]);

        auth()->user()->update([
            'fcm_token' => $request->token
        ]);

        return response()->json(['success' => true]);
    }


}
