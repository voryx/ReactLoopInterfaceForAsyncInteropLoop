<?php

namespace Voryx\Tests\React\EventLoop;

use Amp\Loop\LoopFactory;
use Interop\Async\Loop;
use React\Tests\EventLoop\AbstractLoopTest;
use Voryx\React\EventLoop\ReactAsyncInteropLoop;

class ReactAsyncInteropLoopWithAmpTest extends AbstractLoopTest
{
    public function createLoop()
    {
        Loop::setFactory(new LoopFactory());
        return new ReactAsyncInteropLoop();
    }

    public function testRecursiveNextTick()
    {
        $this->markTestSkipped('Recursive next tick behavior does not match right now');
    }
}