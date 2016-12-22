<?php

namespace Voryx\React\AsyncInterop;

use Interop\Async\Loop;
use React\EventLoop\LoopInterface;
use React\EventLoop\Timer\Timer as ReactTimer;

final class Timer extends ReactTimer
{
    private $timerKey;

    public function __construct($timerKey, $interval, callable $callback, LoopInterface $loop, $isPeriodic = false, $data = null)
    {
        $this->timerKey = $timerKey;

        parent::__construct($loop, $interval, $callback, $isPeriodic, $data);
    }

    public function cancel()
    {
        Loop::get()->cancel($this->timerKey);
    }
}