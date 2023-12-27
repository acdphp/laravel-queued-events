<?php

use Acdphp\QueuedEvents\Jobs\QueuedEventJob;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use Workbench\App\Events\UserCreatedEvent;

test('queuedDispatch should dispatch a job', function () {
    Bus::fake();

    $payload = ['foo' => 'bar'];

    UserCreatedEvent::queuedDispatch($payload);

    Bus::assertDispatched(static function (QueuedEventJob $job) use ($payload) {
        return $job->event->object === $payload;
    });
});

test('queuedDispatchIf should dispatch a job', function () {
    Bus::fake();

    $payload = ['foo' => 'bar'];

    UserCreatedEvent::queuedDispatchIf(true, $payload);

    Bus::assertDispatched(static function (QueuedEventJob $job) use ($payload) {
        return $job->event->object === $payload;
    });
});

test('queuedDispatchUnless should dispatch a job', function () {
    Bus::fake();

    $payload = ['foo' => 'bar'];

    UserCreatedEvent::queuedDispatchUnless(false, $payload);

    Bus::assertDispatched(static function (QueuedEventJob $job) use ($payload) {
        return $job->event->object === $payload;
    });
});

test('queuedDispatchIf event should not dispatch a job if condition is falsy', function () {
    Bus::fake();

    $payload = ['foo' => 'bar'];

    UserCreatedEvent::queuedDispatchIf(false, $payload);

    Bus::assertNotDispatched(QueuedEventJob::class);
});

test('queuedDispatchUnless should not dispatch a job if condition is truthy', function () {
    Bus::fake();

    $payload = ['foo' => 'bar'];

    UserCreatedEvent::queuedDispatchUnless(true, $payload);

    Bus::assertNotDispatched(QueuedEventJob::class);
});

test('event should be dispatched on job handle', function () {
    Event::fake();

    $payload = ['foo' => 'bar'];

    QueuedEventJob::dispatch(new UserCreatedEvent($payload));

    Event::assertDispatched(static function (UserCreatedEvent $event) use ($payload) {
        return $event->object === $payload;
    });
});
