<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kejadian extends Model
{
    use HasFactory;
    protected $table = 'kejadian';
    protected $primaryKey = 'id_kejadian';
    protected $fillable = ['kejadian'];
    public function Laporan_Final(){
        return $this->belongsTo(Laporan_Final::class,'id_kejadian', 'id_kejadian');
    }
}
