React Loop Interface For Async Interop Loop 
======

This library allows you use any [async-interop](https://packagist.org/providers/async-interop/event-loop-implementation) loop with any library that requires the [ReactPHP](https://github.com/reactphp/event-loop) loop.

note: When all ReactPHP projects support the interop loop, this library will no longer be necessary.


## Example

```php
    //Create your async-interop loop
    
    $loop = new \Voryx\React\AsyncInterop\Loop();
    
    //Then use your ReactPHP loop like you normally would
    
    $client = stream_socket_client('tcp://127.0.0.1:1337');
    $conn = new React\Stream\Stream($client, $loop);
    $conn->pipe(new React\Stream\Stream(STDOUT, $loop));
    $conn->write("Hello World!\n");
    
    $loop->run();
```