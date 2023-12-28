<?php

use Acdphp\QueuedEvents\Jobs\QueuedEventJob;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use Workbench\App\Events\UserCreatedEvent;

test('dispatch should dispatch a job and not dispatch event', function () {
    Bus::fake();
    Event::fake();

    $payload = ['foo' => 'bar'];

    UserCreatedEvent::dispatch($payload);

    Bus::assertDispatched(static function (QueuedEventJob $job) use ($payload) {
        return $job->event->object === $payload;
    });

    Event::assertNotDispatched(UserCreatedEvent::class);
});

test('internalDispatch should not dispatch a job and dispatch event', function () {
    Bus::fake();
    Event::fake();

    $payload = ['foo' => 'bar'];

    UserCreatedEvent::internalDispatch($payload);

    Bus::assertNotDispatched(QueuedEventJob::class);

    Event::assertDispatched(static function (UserCreatedEvent $event) use ($payload) {
        return $event->object === $payload;
    });
});

test('dispatchIf should dispatch a job and not dispatch event', function () {
    Bus::fake();
    Event::fake();

    $payload = ['foo' => 'bar'];

    UserCreatedEvent::dispatchIf(true, $payload);

    Bus::assertDispatched(static function (QueuedEventJob $job) use ($payload) {
        return $job->event->object === $payload;
    });

    Event::assertNotDispatched(UserCreatedEvent::class);
});

test('internalDispatchIf should not dispatch a job and dispatch event', function () {
    Bus::fake();
    Event::fake();

    $payload = ['foo' => 'bar'];

    UserCreatedEvent::internalDispatchIf(true, $payload);

    Bus::assertNotDispatched(QueuedEventJob::class);

    Event::assertDispatched(static function (UserCreatedEvent $event) use ($payload) {
        return $event->object === $payload;
    });
});

test('dispatchUnless should dispatch a job and not dispatch event', function () {
    Bus::fake();
    Event::fake();

    $payload = ['foo' => 'bar'];

    UserCreatedEvent::dispatchUnless(false, $payload);

    Bus::assertDispatched(static function (QueuedEventJob $job) use ($payload) {
        return $job->event->object === $payload;
    });

    Event::assertNotDispatched(UserCreatedEvent::class);
});

test('internalDispatchUnless should not dispatch a job and dispatch event', function () {
    Bus::fake();
    Event::fake();

    $payload = ['foo' => 'bar'];

    UserCreatedEvent::internalDispatchUnless(false, $payload);

    Bus::assertNotDispatched(QueuedEventJob::class);

    Event::assertDispatched(static function (UserCreatedEvent $event) use ($payload) {
        return $event->object === $payload;
    });
});

test('dispatchIf event should not dispatch a job if condition is falsy', function () {
    Bus::fake();
    Event::fake();

    $payload = ['foo' => 'bar'];

    UserCreatedEvent::dispatchIf(false, $payload);

    Bus::assertNotDispatched(QueuedEventJob::class);
    Event::assertNotDispatched(UserCreatedEvent::class);
});

test('dispatchUnless should not dispatch a job if condition is truthy', function () {
    Bus::fake();
    Event::fake();

    $payload = ['foo' => 'bar'];

    UserCreatedEvent::dispatchUnless(true, $payload);

    Bus::assertNotDispatched(QueuedEventJob::class);
    Event::assertNotDispatched(UserCreatedEvent::class);
});

test('event should be dispatched on job handle', function () {
    Event::fake();

    $payload = ['foo' => 'bar'];

    config('queued_events.job')::dispatch(new UserCreatedEvent($payload));

    Event::assertDispatched(static function (UserCreatedEvent $event) use ($payload) {
        return $event->object === $payload;
    });
});
