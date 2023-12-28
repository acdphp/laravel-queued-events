<?php

return [
    'default_queue_connection' => env('QUEUED_EVENTS_QUEUE_CONNECTION', env('QUEUE_CONNECTION')),

    'default_queue' => env('QUEUED_EVENTS_QUEUE', 'default'),

    'job' => \Acdphp\QueuedEvents\Jobs\QueuedEventJob::class,
];
