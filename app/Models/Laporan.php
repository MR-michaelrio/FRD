<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;
    protected $table = 'Laporan';

    protected $primaryKey = 'id_kejadian';

    protected $fillable = ['kejadian', 'objek', 'terima_berita', 'situasi', 'pengerahan_akhir', 'alamat','tanggal','responder','status','regu','petugas_piket','nama_petugas','waktu_selesai'];
}
