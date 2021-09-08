<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Worksome\CodingStyle\Rector\Generic\Class_\NamespaceBasedSuffixRector;
use Worksome\CodingStyle\Rector\Generic\Class_\ParentBasedSuffixRector;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->set(ParentBasedSuffixRector::class)
        ->call('configure', [[
            ParentBasedSuffixRector::PARENT_AND_SUFFIX => [
                'App\\Jobs\\Job' => 'Job',
                'App\\Jobs\\SomeInterface' => 'Job',
            ],
        ]]);
};