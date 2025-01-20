<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    protected $table = "absensi";
    protected $primaryKey = "id_absensi";

    protected $fillable = ['id_absensi', 'id_absen', 'id_anggota','absenshadir','alasan','wilayah'];

    public function Absen(){
        return $this->belongsTo(Absen::class,'id_absen', 'id_absen');
    }

    public function anggota(){
        return $this->belongsTo(anggota::class,'id_anggota', 'id_anggota');
    }
}
