<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Worksome\CodingStyle\Rector\Generic\DisallowedAttributesRector;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(DisallowedAttributesRector::class)
        ->configure([
            JetBrains\PhpStorm\Pure::class,
        ]);
};
