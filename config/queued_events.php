<?php

return [
    'default_queue_connection' => env('QUEUED_EVENTS_QUEUE_CONNECTION', env('QUEUE_CONNECTION')),

    'default_queue' => env('QUEUED_EVENTS_QUEUE', 'default'),

    'job' => \Acdphp\QueuedEvents\Jobs\QueuedEventJob::class,

    'missing_event_class' => [
        /*
         * The number of times the job may be attempted when event class doesn't exist.
         */
        'tries' => 0,

        /*
         * The number of seconds to wait before retrying the job when event class doesn't exist.
         *
         * Values can be number or array of numbers (same as job backoff).
         */
        'backoff' => [],

        /*
         * Should it throw a MissingEventClassException when event class doesn't exist after retries.
         */
        'suppress_error' => false,
    ],
];
