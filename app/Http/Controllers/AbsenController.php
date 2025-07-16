<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absen;
use App\Models\Absensi;
use App\Models\anggota;
use App\Models\Wilayah;
use Illuminate\Support\Str;
use PDF;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class AbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $absen = Absen::orderBy('created_at', 'desc')->get();
        return view('absensi.index', compact('absen'));
    }

    public function indexByWilayah($wilayah)
    {
        $anggota = Anggota::where('role', '!=', 'anggota')
                    ->where('role', '!=', 'admin')
                    ->where('wilayah', $wilayah)
                    ->get();

        $ag = Anggota::where('wilayah', $wilayah)->where('role', '!=', 'admin')->get();
        $namawilayah = Wilayah::where('id_wilayah', $wilayah)->first();

        return view('absensi.absen', compact('anggota', 'ag', 'namawilayah'));
    }


    public function index2()
    {
        $anggota = anggota::where('role','!=','anggota')->where('wilayah','1')->get();
        $ag = anggota::all()->where('wilayah','1');
        $id = 'jakarta';
        $namawilayah = Wilayah::where('id_wilayah', $id)->first();
        return view('absensi.absen', compact('anggota','ag','id', 'namawilayah'));
    }

    public function index3()
    {
        $anggota = Anggota::where('role', '!=', 'anggota')->where('wilayah', '2')->get();
        $ag = anggota::all()->where('wilayah','2');
        $id = 'bekasi';
        $namawilayah = Wilayah::where('id_wilayah', $id)->first();
        return view('absensi.absen', compact('anggota','ag','id','namawilayah'));
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
        //
    }
    
    public function store2(Request $request)
    {
        // Generate a unique random ID for 'Absen'
        $id_absen = rand(100000, 999999);
        while (Absen::where('id_absen', $id_absen)->exists()) {
            $id_absen = rand(100000, 999999);
        }
        // return $request->wilayah;
        // Create the 'Absen' record
        $absen = Absen::create([
            'id_absen' => $id_absen,
            'tanggal_absen' => $request->tanggal_absen,
            'id_anggota' => $request->petugas,
            'catatan' => $request->catatan,
            'wilayah' => $request->wilayah
        ]);
        
        // Process attendance for each member
        $ag = anggota::all()->where('wilayah',$request->wilayah);
        foreach ($ag as $a) {
            $hadirKey = 'absenshadir.' . $a->id_anggota;
            $selectedValue = $request->input($hadirKey);
            
            // Check if "Lain" is selected and "Lain Text" is provided; otherwise, default to "Hadir" or "Tidak Hadir"
            if ($selectedValue === 'lain' && $request->has("lainText.{$a->id_anggota}")) {
                $absenshadir = $request->input("lainText.{$a->id_anggota}");
            } else {
                $absenshadir = $selectedValue === 'hadir' ? 'hadir' : 'tidak hadir';
            }
            // Create the 'Absensi' record
            Absensi::create([
                'id_absen' => $absen->id_absen,
                'id_anggota' => $a->id_anggota,
                'absenshadir' => $absenshadir,
                'wilayah' => $request->wilayah
            ]);
        }
        return redirect()->route('absen.pdf',$absen->id_absen);    
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Absensi::join('anggota', 'absensi.id_anggota', '=', 'anggota.id_anggota')
        ->where('absensi.id_absen', $id)
        ->get();
        $tanggal = Absen::find($id);
        
        return view('absensi.show',compact('data','tanggal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_anggota,$id_absen)
    {
        $absen = Absensi::where('id_anggota', $id_anggota)
        ->where('id_absen', $id_absen)
        ->first();
        return view('absensi.editabsen',compact('absen'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_anggota,$id_absen)
    {
        //
        $absen = Absensi::where('id_anggota', $id_anggota)
        ->where('id_absen', $id_absen)
        ->first();
        $a= $absen->update([
            'absenshadir' => $request->absenshadir
        ]);
        return redirect()->route('absen.show',$absen->id_absen);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $absensi = Absensi::where('id_absen',$id)->get();
        $absen = Absen::find($id);
        if ($absen) {
            foreach ($absensi as $absensiItem) {
                $absensiItem->delete();
            }
        
            if (!empty($absen->pdf)) {
                $filePath = public_path($absen->pdf);
        
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }
        
            $absen->delete();
        }

        return redirect()->route('absen.index');
    }

    public function generatePDF($id)
    {
        $data = absensi::where('id_absen',$id)->get();
        $absen = Absen::find($id);
        $wilayah = Wilayah::where("id_wilayah",$absen->wilayah)->first();

        $pdf = PDF::loadView('absensi.pdf', compact('data','absen','wilayah'));
        $pdfContent = $pdf->output();
        $publicPath = public_path('pdf');
        if (!is_dir($publicPath)) {
            mkdir($publicPath, 0755, true);
        }
        $pdfFileName = $id . '.pdf';
        $pdfFilePath = $publicPath . '/' . $pdfFileName;
        $pdf->save($pdfFilePath);
        $absen->update(['pdf' => 'pdf/' . $pdfFileName]);
        return redirect("http://101.255.101.60:3000/absen?namafile=".$pdfFileName."&wilayah=".$wilayah->id_wilayah);
    }
}
