<?php

namespace Voryx\React\AsyncInterop;

use Interop\Async\Loop as InteropLoop;
use React\EventLoop\LoopInterface;
use React\EventLoop\Timer\TimerInterface;

final class Loop implements LoopInterface
{
    private $readStreams = [];
    private $writeStreams = [];

    public function addReadStream($stream, callable $listener)
    {
        $key = (int)$stream;
        if (isset($this->readStreams[$key])) {
            throw new \Exception('key set twice');
        }
        $this->readStreams[$key] = InteropLoop::get()->onReadable($stream, function () use ($listener, $stream) {
            $listener($stream);
        });
    }

    public function addWriteStream($stream, callable $listener)
    {
        $key = (int)$stream;

        if (isset($this->writeStreams[$key])) {
            throw new \Exception('key set twice');
        }

        $this->writeStreams[$key] = InteropLoop::get()->onWritable($stream, function () use ($listener, $stream) {
            $listener($stream);
        });
    }

    public function removeReadStream($stream)
    {
        $key = (int)$stream;
        if (isset($this->readStreams[$key])) {
            InteropLoop::get()->cancel($this->readStreams[$key]);
            unset($this->readStreams[$key]);
        }
    }

    public function removeWriteStream($stream)
    {
        $key = (int)$stream;
        if (isset($this->writeStreams[$key])) {
            InteropLoop::get()->cancel($this->writeStreams[$key]);
            unset($this->writeStreams[$key]);
        }
    }

    public function removeStream($stream)
    {
        $this->removeReadStream($stream);
        $this->removeWriteStream($stream);
    }

    private function addWrappedTimer($interval, callable $callback, $isPeriodic = false)
    {
        $wrappedCallback = function () use (&$timer, $callback) {
            $callback($timer);
        };
        $millis          = $interval * 1000;
        if ($isPeriodic) {
            $timerKey = InteropLoop::get()->repeat($millis, $wrappedCallback);
        } else {
            $timerKey = InteropLoop::get()->delay($millis, $wrappedCallback);
        }
        $timer = new Timer(
            $timerKey,
            $interval,
            $callback,
            $this,
            false
        );
        return $timer;
    }

    public function addTimer($interval, callable $callback)
    {
        return $this->addWrappedTimer($interval, $callback);
    }

    public function addPeriodicTimer($interval, callable $callback)
    {
        return $this->addWrappedTimer($interval, $callback, true);
    }

    public function cancelTimer(TimerInterface $timer)
    {
        $timer->cancel();
    }

    public function isTimerActive(TimerInterface $timer)
    {
        return $timer->isActive();
    }

    public function nextTick(callable $listener)
    {
        InteropLoop::get()->defer(function () use ($listener) {
            $listener($this);
        });
    }

    public function futureTick(callable $listener)
    {
        $this->nextTick($listener);
    }

    public function tick()
    {
        $loop = InteropLoop::get();

        $loop->defer(function () use ($loop) {
            $loop->stop();
        });

        $loop->run();
    }

    public function run()
    {
        InteropLoop::get()->run();
    }

    public function stop()
    {
        InteropLoop::get()->stop();
    }
}