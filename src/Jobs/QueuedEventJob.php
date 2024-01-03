<?php

namespace Acdphp\QueuedEvents\Jobs;

use Acdphp\QueuedEvents\Exceptions\MissingEventClassException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class QueuedEventJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public int $missingEventClassAttempts = 1;

    public function __construct(
        public string $eventClass,
        public array $arguments
    ) {
        $this->onConnection(config('queued_events.default_queue_connection'))
            ->onQueue(config('queued_events.default_queue'));
    }

    public function handle(): void
    {
        if (! @class_exists($this->eventClass)) {
            $this->reQueueJob();

            return;
        }

        call_user_func([$this->eventClass, 'internalDispatch'], ...$this->arguments);
    }

    private function reQueueJob(): void
    {
        $this->delete();

        if (
            $this->missingEventClassAttempts < $this->missingEventClassMaxTries() &&
            $this->job->isDeleted()
        ) {
            $job = new self(
                $this->eventClass,
                $this->arguments
            );
            $job->missingEventClassAttempts = $this->missingEventClassAttempts + 1;

            dispatch($job)->delay($this->getCurrentMissingEventClassBackOff());
        } elseif (! config('queued_events.missing_event_class.suppress_error')) {
            throw new MissingEventClassException(sprintf('Missing event class: %s', $this->eventClass));
        }
    }

    private function missingEventClassMaxTries(): int
    {
        return config('queued_events.missing_event_class.tries');
    }

    private function missingEventClassBackoff(): array|int|null
    {
        return config('queued_events.missing_event_class.backoff');
    }

    private function getCurrentMissingEventClassBackOff(): int
    {
        $backOffConfig = $this->missingEventClassBackoff();

        // null
        if (empty($backOffConfig)) {
            return 0;
        }

        // single backoff
        if (is_int($backOffConfig)) {
            return $this->missingEventClassBackoff();
        }

        // array backoff
        if ($this->missingEventClassAttempts > count($backOffConfig)) {
            return end($backOffConfig);
        }

        return $backOffConfig[$this->missingEventClassAttempts - 1];
    }
}
