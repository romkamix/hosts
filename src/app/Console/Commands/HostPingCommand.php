<?php

namespace Romkamix\App\Console\Commands;

use Illuminate\Console\Command;
use Romkamix\App\Jobs\HostPingJob;
use Romkamix\App\Models\Host;

class HostPingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'host:ping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Host::each(function ($host) {
            HostPingJob::dispatch($host);
        });

        return Command::SUCCESS;
    }
}
