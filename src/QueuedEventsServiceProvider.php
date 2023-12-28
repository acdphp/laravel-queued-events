<?php

namespace Acdphp\QueuedEvents;

use Illuminate\Support\ServiceProvider;

class QueuedEventsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/queued_events.php', 'queued_events'
        );
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/queued_events.php' => config_path('queued_events.php'),
        ], 'queued-events-config');
    }
}
