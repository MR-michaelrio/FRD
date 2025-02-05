<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserApproval extends Model {
    use HasFactory;
    protected $table = "user_approvals";
    protected $fillable = ['id_user', 'supervisor', 'approved_at'];
}
