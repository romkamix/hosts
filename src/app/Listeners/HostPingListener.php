<?php

namespace Romkamix\App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Romkamix\App\Events\HostPingEvent;
use Romkamix\App\Mail\HostPingMail;

class HostPingListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\HostTracked  $event
     * @return void
     */
    public function handle(HostPingEvent $event)
    {
        Mail::to('it@stildrevstroy.ru')
            ->queue(new HostPingMail($event->ping));
    }
}
