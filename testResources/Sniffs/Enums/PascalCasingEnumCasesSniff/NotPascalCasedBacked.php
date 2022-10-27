<?php

namespace Worksome\WorksomeSniff\Tests\Resources\Sniffs\Functions\DisallowCompactUsageSniff;


enum NotPascalCasedBacked: string
{
    case First = 'first';
    case Second = 'second';

    case thirty_four= 'works';
}
