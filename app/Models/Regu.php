<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regu extends Model
{
    use HasFactory;
    protected $table = "regu";
    protected $primaryKey = "id_regu";

    protected $fillable = ['id_regu', 'nama_regu'];
    
    public function anggota(){
        return $this->belongsTo(anggota::class,'id_regu', 'id_regu');
    }
}
