<?php

namespace App\Enums;

enum NotPascalCasedBacked: string
{
    case First = 'first';
    case Second = 'second';

    case thirty_four = 'works';
}
