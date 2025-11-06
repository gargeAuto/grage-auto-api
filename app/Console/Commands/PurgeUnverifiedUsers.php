<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class PurgeUnverifiedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:purge-unverified-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
          $deleted = User::whereNull('email_verified_at')
            ->where('created_at', '<', now()->subMinutes(5))
            ->delete();

        $this->info("$deleted utilisateurs non vérifiés supprimés.");
    }
}
