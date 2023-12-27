<?php

namespace Acdphp\QueuedEvents\Jobs;

use Acdphp\QueuedEvents\Events\QueuedEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class QueuedEventJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public function __construct(public QueuedEvent $event)
    {
        $this->onConnection(config('queued_events.default_queue_connection'))
            ->onQueue(config('queued_events.default_queue'));
    }

    public function handle(): void
    {
        event($this->event);
    }
}
