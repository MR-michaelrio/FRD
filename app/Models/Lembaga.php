<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lembaga extends Model
{
    use HasFactory;

    protected $table = 'lembaga';

    protected $primaryKey = 'id_lembaga';

    protected $fillable = ['nama_lembaga', 'id_supervisor', 'status', 'logo_lembaga'];
}
