<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Worksome\CodingStyle\Rector\Generic\Class_\NamespaceBasedSuffixRector;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->set(NamespaceBasedSuffixRector::class)
        ->call('configure', [[
            NamespaceBasedSuffixRector::NAMESPACE_AND_SUFFIX => [
                'App\\Events\\' => 'Event',
                'App\\Listener\\' => 'Listener',
            ],
        ]]);
};