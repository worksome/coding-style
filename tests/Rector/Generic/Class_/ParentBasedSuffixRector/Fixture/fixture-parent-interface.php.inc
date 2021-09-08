<?php

namespace App\Jobs;

interface SomeInterface {

}

class SomeJob implements SomeInterface {
}

class DoAwesomeInterfaceParent extends SomeJob
{

}

?>
-----
<?php

namespace App\Jobs;

interface SomeInterface {

}

class SomeJob implements SomeInterface {
}

class DoAwesomeInterfaceParentJob extends SomeJob
{

}

?>