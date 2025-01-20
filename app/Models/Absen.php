<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;
    protected $table = "absen";
    protected $primaryKey = "id_absen";

    protected $fillable = ['id_absen', 'tanggal_absen', 'id_anggota', 'catatan','pdf','wilayah'];

    public function Absensi(){
        return $this->belongsTo(Absen::class,'id_absen', 'id_absen');
    }
}
