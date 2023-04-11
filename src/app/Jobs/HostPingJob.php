<?php

namespace Romkamix\App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Romkamix\App\Events\HostPingEvent;
use Romkamix\App\Models\Host;

class HostPingJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds after which the job's unique lock will be released.
     *
     * @var int
     */
    public $uniqueFor = 3600;

    /**
     * The host instance.
     *
     * @var \Romkamix\App\Models\Host
     */
    public $host = null;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Host $host)
    {
        $this->host = $host;
    }

    /**
     * The unique ID of the job.
     */
    public function uniqueId(): string
    {
        return $this->host->id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $lastPing = $this->host->lastPing;
        $ping = $this->host->ping();

        if (
            !is_null($ping) &&
            (is_null($lastPing) || $lastPing->success !== $ping->success)
        ) {
            event(new HostPingEvent($ping));
        }
    }
}
