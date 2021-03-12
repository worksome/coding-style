<?php

namespace Worksome\CodingStyle;

use Rector\Core\Configuration\Option;
use Rector\Php80\Rector\Catch_\RemoveUnusedVariableInCatchRector;
use Rector\Php80\Rector\FuncCall\ClassOnObjectRector;
use Rector\Php80\Rector\Identical\StrEndsWithRector;
use Rector\Php80\Rector\Identical\StrStartsWithRector;
use Rector\Php80\Rector\NotIdentical\StrContainsRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

class WorksomeRectorConfig
{
    public static function setup(ContainerConfigurator $containerConfigurator)
    {
        // get parameters
        $parameters = $containerConfigurator->parameters();

        $parameters->set(Option::AUTOLOAD_PATHS, [
            getcwd() . '/vendor/nunomaduro/larastan/bootstrap.php',
        ]);

        $parameters->set(Option::PHPSTAN_FOR_RECTOR_PATH, getcwd() . '/phpstan.neon');
        $parameters->set(Option::ENABLE_CACHE, true);

        // Define what rule sets will be applied
        $parameters->set(Option::SETS, [
            // SetList::DEAD_CODE,
            // SetList::PHP_80,
        ]);

        // get services (needed for register a single rule)
        $services = $containerConfigurator->services();

        // register a single rule
        $services->set(ClassOnObjectRector::class);
        $services->set(StrContainsRector::class);
        $services->set(StrStartsWithRector::class);
        $services->set(StrEndsWithRector::class);
        $services->set(RemoveUnusedVariableInCatchRector::class);

        // DEAD CODE set rules
        $services->set(\Rector\DeadCode\Rector\FunctionLike\RemoveCodeAfterReturnRector::class);
        $services->set(\Rector\DeadCode\Rector\ClassMethod\RemoveDeadConstructorRector::class);

        // Naming set rules
        $services->set(\Rector\Naming\Rector\Property\UnderscoreToCamelCasePropertyNameRector::class);
    }
}