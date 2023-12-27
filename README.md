# Laravel Queued Events
[![Latest Stable Version](https://poser.pugx.org/acdphp/laravel-queued-events/v)](https://packagist.org/packages/acdphp/laravel-queued-events)

Dispatching Events into queues. This is especially useful for distributed systems events using fanout queues.

![workflow](./.docs/workflow.jpg)

## Installation
1. Install the package
    ```shell
    composer require acdphp/laravel-queued-events
    ```
   
## Usage
1. Extend `QueuedEvent` to your event.
   ```php
   use Acdphp\QueuedEvents\Events\QueuedEvent;
   use Illuminate\Foundation\Events\Dispatchable;
  
   class UserCreatedEvent extends QueuedEvent
   {
       use Dispatchable;
      
       public function __construct(public $object)
       {
       }
   }
   ```

2. Call `queuedDispatch()`
   ```php
   UserCreatedEvent::queuedDispatch(['foo' => 'bar']);
   ```
   
- You may specify a queue connection and queue:
   ```php
   UserCreatedEvent::queuedDispatch(['foo' => 'bar'])
       ->onConnection('your-fanout-queue-connection')
       ->onQueue('your-custom-queue');
   ```
  
- Utilities are also available: `queuedDispatchIf()`, `queuedDispatchUnless()`
    ```php
   // Dispatches if $condition is true
   UserCreatedEvent::queuedDispatchIf($condition, ['foo' => 'bar']);
   
   // Dispatches if $condition is false
   UserCreatedEvent::queuedDispatchUnless($condition, ['foo' => 'bar']);
   ```

## Configuration
- By default, the queue connection will be whatever your `QUEUE_CONNECTION` is set. You may override this by setting `QUEUED_EVENTS_QUEUE_CONNECTION`
- By default, the queue will be `default`. You may override this by setting `QUEUED_EVENTS_QUEUE`
- This config, of course, can be overridden in your code as seen from the queuedDispatch usage example.

## Notes
- Use Laravel's queued listener if you're only using this in a standalone system. 

## License
The MIT License (MIT). Please see [License File](LICENSE) for more information.
