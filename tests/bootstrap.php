<?php

$loader = @include __DIR__ . '/../vendor/autoload.php';
$loader->addPsr4('React\\Tests\\EventLoop\\', __DIR__ . '/../vendor/react/event-loop/tests/');
