<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncUsersAnggota extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:users-anggota';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize User accounts with Anggota records based on Name';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = \App\Models\User::all();
        $matched = 0;
        $updated = 0;
        $notFound = [];

        foreach ($users as $user) {
            if ($user->name === 'admin' || $user->email === 'admin@admin.com') {
                continue;
            }

            $name = trim($user->name);
            
            // Find matching anggota
            $anggota = \App\Models\Anggota::where('nama', $name)
                ->orWhere('nama', 'LIKE', '%' . $name . '%')
                ->first();

            if ($anggota) {
                $matched++;
                
                $user->id_anggota = $anggota->id_anggota;
                $user->regu = $anggota->id_regu;
                $user->wilayah = $anggota->wilayah;
                
                if ($user->isDirty()) {
                    $user->save();
                    $updated++;
                    $this->info("Updated User: {$user->name} (ID: {$user->id}) -> Anggota ID: {$anggota->id_anggota}");
                }
            } else {
                $notFound[] = $user->name;
            }
        }

        $this->info("Sync complete. Matched: {$matched}, Updated: {$updated}");
        if (!empty($notFound)) {
            $this->warn("Users not found: " . implode(', ', $notFound));
        }

        return 0;
    }

}
