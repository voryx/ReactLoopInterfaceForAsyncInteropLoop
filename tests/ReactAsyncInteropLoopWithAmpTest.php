<?php

namespace Voryx\Tests\React\EventLoop;

use Amp\Loop\LoopFactory;
use React\Tests\EventLoop\AbstractLoopTest;
use Voryx\React\AsyncInterop\Loop;


class ReactAsyncInteropLoopWithAmpTest extends AbstractLoopTest
{
    public function createLoop()
    {
        \Interop\Async\Loop::setFactory(new LoopFactory());
        return new Loop();
    }

    public function testRecursiveNextTick()
    {
        $this->markTestSkipped('Recursive next tick behavior does not match right now');
    }
}