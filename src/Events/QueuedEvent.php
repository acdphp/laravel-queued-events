<?php

namespace Acdphp\QueuedEvents\Events;

use Acdphp\QueuedEvents\Jobs\QueuedEventJob;
use Illuminate\Foundation\Bus\PendingDispatch;

class QueuedEvent
{
    public static function queuedDispatch(): PendingDispatch
    {
        /**
         * @phpstan-ignore-next-line
         */
        return QueuedEventJob::dispatch(new static(...func_get_args()));
    }

    public static function queuedDispatchIf(bool $boolean, mixed ...$arguments): ?PendingDispatch
    {
        if ($boolean) {
            return static::queuedDispatch(...$arguments);
        }

        return null;
    }

    public static function queuedDispatchUnless(bool $boolean, mixed ...$arguments): ?PendingDispatch
    {
        if (! $boolean) {
            return static::queuedDispatch(...$arguments);
        }

        return null;
    }
}
