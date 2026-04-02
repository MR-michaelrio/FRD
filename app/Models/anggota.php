<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;
    protected $table = "anggota";
    protected $primaryKey = "id_anggota";

    protected $fillable = ['id_anggota', 'nama', 'lembaga', 'alamat', 'no_pemegang', 'no_darurat1', 'nama_darurat1', 'no_darurat2', 'nama_darurat2', 'tanggal_lahir', 'jenis_kelamin', 'id_regu', 'role','wilayah'];

    public function Absensi(){
        return $this->belongsTo(Absensi::class,'id_anggota', 'id_anggota');
    }

    public function Regu(){
        return $this->belongsTo(Regu::class,'id_regu', 'id_regu');
    }

    public function isApproved() {
        $totalSupervisors = DB::table('users')->where('level', 'supervisor')->count();
        return $this->approvals()->count() >= $totalSupervisors;
    }

    public function user()
    {
        return $this->belongsTo(User::class,'id_anggota', 'id_anggota');
    }

    public function Lembaga()
    {
        return $this->belongsTo(Lembaga::class,'lembaga', 'id_lembaga');
    }

}
