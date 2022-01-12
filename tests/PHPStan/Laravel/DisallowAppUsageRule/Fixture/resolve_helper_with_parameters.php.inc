<?php

class CallsResolveHelper
{
    public function method()
    {
        return \resolve('myService', ['foo' => 'bar']);
    }
}

?>
