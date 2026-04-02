<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SystemCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run system diagnostic checks (symlinks, database, permissions)';

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
        $this->info("Starting System Diagnostic Checks...");
        $errors = 0;

        // 1. Check DB Connection
        try {
            \DB::connection()->getPdo();
            $this->info("✅ Database Connection: OK");
        } catch (\Exception $e) {
            $this->error("❌ Database Connection: Failed (" . $e->getMessage() . ")");
            $errors++;
        }

        // 2. Check Storage Symlink
        if (is_link(public_path('storage'))) {
            $this->info("✅ Storage Symlink: OK");
        } else {
            $this->warn("⚠️ Storage Symlink: Missing or broken. Run 'php artisan storage:link'");
            $errors++;
        }

        // 3. Check Writable Directories
        $paths = ['storage', 'bootstrap/cache', 'public/storage'];
        foreach ($paths as $path) {
            if (is_writable(base_path($path))) {
                $this->info("✅ Writable Path [{$path}]: OK");
            } else {
                $this->error("❌ Writable Path [{$path}]: Failed (Check permissions)");
                $errors++;
            }
        }

        // 4. Check for Windows Garbage
        $garbage = ['C:', 'laragon', 'www'];
        foreach ($garbage as $g) {
            if (file_exists(base_path($g))) {
                $this->warn("⚠️ Found potential Windows migration garbage: {$g}");
            }
        }

        if ($errors === 0) {
            $this->info("🎉 System check completed successfully with no errors.");
        } else {
            $this->warn("🚧 System check completed with {$errors} issues.");
        }

        return $errors > 0 ? 1 : 0;
    }

}
