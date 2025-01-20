<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan_Final extends Model
{
    use HasFactory;
    protected $table = 'Laporan_Final';

    protected $primaryKey = 'id_laporan';

    protected $fillable = ['nama_petugas', 'id_kejadian', 'tanggal', 'petugas_piket', 'regu', 'id_kejadian'];
    public function Kejadian(){
        return $this->belongsTo(Kejadian::class,'id_kejadian', 'id_kejadian');
    }
}
