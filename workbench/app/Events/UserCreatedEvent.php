<?php

namespace Workbench\App\Events;

use Acdphp\QueuedEvents\Events\QueuedEvent;

class UserCreatedEvent extends QueuedEvent
{
    public function __construct(public $object)
    {
    }
}
