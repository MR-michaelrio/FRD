<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserApproval extends Model {
    use HasFactory;
    protected $table = "user_approvals";
    protected $fillable = ['id_user', 'supervisor', 'approved_at'];
    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function supervisor() {
        return $this->belongsTo(User::class, 'id_supervisor');
    }
}
