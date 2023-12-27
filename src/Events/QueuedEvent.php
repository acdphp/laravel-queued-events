<?php

namespace Acdphp\QueuedEvents\Events;

use Acdphp\QueuedEvents\Jobs\QueuedEventJob;
use Illuminate\Foundation\Bus\PendingDispatch;

class QueuedEvent
{
    public static function queuedDispatch(): PendingDispatch
    {
        return QueuedEventJob::dispatch(new static(...func_get_args()));
    }

    public static function queuedDispatchIf($boolean, ...$arguments): PendingDispatch|null
    {
        if ($boolean) {
            return static::queuedDispatch(...$arguments);
        }

        return null;
    }

    public static function queuedDispatchUnless($boolean, ...$arguments): PendingDispatch|null
    {
        if (! $boolean) {
            return static::queuedDispatch(...$arguments);
        }

        return null;
    }
}
