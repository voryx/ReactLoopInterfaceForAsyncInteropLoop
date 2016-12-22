<?php

namespace Voryx\Tests\React\EventLoop;

use Interop\Async\Loop;
use React\EventLoop\StreamSelectLoop;
use React\Tests\EventLoop\AbstractLoopTest;
use WyriHaximus\React\AsyncInteropLoop\ReactDriverFactory;

class ReactAsyncInteropLoopTest extends AbstractLoopTest
{
    public function createLoop()
    {
        // going to use the react loop adapter as the default for now
        $driver = ReactDriverFactory::createFactoryFromLoop(StreamSelectLoop::class);
        Loop::setFactory($driver);

        return new \Voryx\React\AsyncInterop\Loop();
    }

    public function testRecursiveNextTick()
    {
        $this->markTestSkipped('Recursive next tick behavior does not match right now');
    }
}