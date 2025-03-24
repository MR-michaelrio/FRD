<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserApproval;
use App\Models\User;
use Auth;

class ApprovalController extends Controller
{
    public function index()
    {
        $anggota = User::where('status', 'pending')->get();
        return view("anggota.approval",compact("anggota"));
    }

    public function approveUser($userId)
    {
        $supervisorId = Auth::id();

        // Cek apakah user sudah disetujui oleh supervisor ini
        $existingApproval = UserApproval::where('id_user', $userId)
                                        ->where('supervisor', $supervisorId)
                                        ->first();

        if ($existingApproval) {
            return redirect()->back()->with('sweetalert', [
                'title' => 'Approval Gagal!',
                'text' => 'Anda sudah menyetujui user ini sebelumnya.',
                'icon' => 'warning'
            ]);
        }

        // Simpan approval baru
        UserApproval::create([
            'id_user' => $userId,
            'supervisor' => $supervisorId,
            'approved_at' => now()
        ]);

        // Cek apakah user sudah disetujui oleh semua supervisor
        $user = User::find($userId);
        if ($user->isApproved()) {
            $user->update(['status' => 'active']);
            UserApproval::where('id_user', $userId)->delete();
        }

        return redirect()->back()->with('sweetalert', [
            'title' => 'Approval Sukses',
            'text' => 'Akun Ini Sudah Bisa Digunakan.',
            'icon' => 'success'
        ]);
    }

    public function deleteapproveUser($userId)
    {
        // Cari user berdasarkan ID
        $user = User::where('id', $userId)->first();

        if ($user) {
            $user->delete(); // Hapus user
        }

        // Hapus semua approval terkait user ini
        UserApproval::where('id_user', $userId)->delete();

        return redirect()->back()->with('sweetalert', [
            'title' => 'Menghapus User',
            'text' => 'Akun Ini Sudah Dihapus',
            'icon' => 'success'
        ]);
    }

}
