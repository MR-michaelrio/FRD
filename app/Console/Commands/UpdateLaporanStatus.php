<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Laporan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateLaporanStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:laporan-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the status of laporan records every day at 8 AM';

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
    Log::info('Executing update:laporan-status command.');

    // Check if the user is authenticated
    $laporans = Laporan::where('status', 'selesai')
        ->whereBetween('updated_at', [Carbon::yesterday(), Carbon::now()])
        ->get();

    Log::info('update:laporan-status command executed successfully.');

    // Return 0 to indicate successful execution
    return 0;


}
    

}
