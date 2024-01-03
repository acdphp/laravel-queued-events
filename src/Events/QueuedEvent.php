<?php

namespace Acdphp\QueuedEvents\Events;

use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Foundation\Events\Dispatchable;

class QueuedEvent
{
    use Dispatchable
    {
        dispatch as internalDispatch;
        dispatchIf as internalDispatchIf;
        dispatchUnless as internalDispatchUnless;
    }

    public static function dispatch(): PendingDispatch
    {
        return config('queued_events.job')::dispatch(static::class, func_get_args());
    }

    public static function dispatchIf(bool $boolean, mixed ...$arguments): ?PendingDispatch
    {
        if ($boolean) {
            return static::dispatch(...$arguments);
        }

        return null;
    }

    public static function dispatchUnless(bool $boolean, mixed ...$arguments): ?PendingDispatch
    {
        if (! $boolean) {
            return static::dispatch(...$arguments);
        }

        return null;
    }
}
