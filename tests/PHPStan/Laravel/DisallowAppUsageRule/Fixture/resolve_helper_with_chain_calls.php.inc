<?php

namespace Resolve\Services;

class CallsResolveHelper
{
    public function method()
    {
        return \resolve('myService')->execute();
    }
}

?>
