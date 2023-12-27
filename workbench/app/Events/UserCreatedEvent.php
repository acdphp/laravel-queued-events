<?php

namespace Workbench\App\Events;

use Acdphp\QueuedEvents\Events\QueuedEvent;
use Illuminate\Foundation\Events\Dispatchable;

class UserCreatedEvent extends QueuedEvent
{
    use Dispatchable;

    public function __construct(public $object)
    {
    }
}
