<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'level',
        'regu',
        'id_anggota',
        'wilayah',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function approvals()
    {
        return $this->hasMany(UserApproval::class, 'id_user', 'id');
    }
    
    public function isApproved() {
        // Hitung jumlah supervisor dan admin yang menyetujui
        $approvedCount = $this->approvals()
            ->whereIn('level', ['supervisor', 'admin']) // Hanya supervisor atau admin
            ->count();
    
        return $approvedCount >= 2; // Minimal 2 yang menyetujui
    }
    

    
}
