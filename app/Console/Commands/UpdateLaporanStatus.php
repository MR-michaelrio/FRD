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

    // Convert the laporans collection to an array
    $laporansArray = $laporans->toArray();

    // Encode the array to a JSON format for URL safety
    $encodedLaporans = urlencode(json_encode($laporansArray));

    // Access user properties if the user is authenticated
    $redirectUrl = 'http://101.255.101.60:3000/laporanfinal?tanggal_kejadian=' . Carbon::yesterday() . '&kejadian=' . $encodedLaporans;

    // Display an informational message
    $this->info('Making HTTP request to: ' . $redirectUrl);

    // Make an HTTP request to the desired endpoint
    $response = Http::get($redirectUrl);

    // Display the response status and content
    $this->info('HTTP Response Status: ' . $response->status());
    Log::info('update:laporan-status command executed successfully.');

    // Return 0 to indicate successful execution
    return 0;


}
    

}
