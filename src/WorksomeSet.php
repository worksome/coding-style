<?php

declare(strict_types=1);

namespace Worksome\CodingStyle;

enum WorksomeSet: string
{
    case Ecs = __DIR__ . '/Sets/ecs.php';
    case Rector = __DIR__ . '/Sets/rector.php';
}
