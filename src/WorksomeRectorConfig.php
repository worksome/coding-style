<?php

namespace Worksome\CodingStyle;

use Rector\Core\Configuration\Option;
use Rector\DeadCode\Rector\ClassMethod\RemoveDelegatingParentCallRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\DeadCode\Rector\Node\RemoveNonExistingVarAnnotationRector;
use Rector\Php80\Rector\Catch_\RemoveUnusedVariableInCatchRector;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\Php80\Rector\FuncCall\ClassOnObjectRector;
use Rector\Php80\Rector\Identical\StrEndsWithRector;
use Rector\Php80\Rector\Identical\StrStartsWithRector;
use Rector\Php80\Rector\NotIdentical\StrContainsRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Worksome\CodingStyle\Rector\WorksomeSetList;

class WorksomeRectorConfig
{
    public static function setup(ContainerConfigurator $containerConfigurator)
    {
        // get parameters
        $parameters = $containerConfigurator->parameters();

        $parameters->set(Option::BOOTSTRAP_FILES, [
            getcwd() . '/vendor/nunomaduro/larastan/bootstrap.php',
        ]);

        $parameters->set(Option::PHPSTAN_FOR_RECTOR_PATH, getcwd() . '/phpstan.neon');

        // Define what rule sets will be applied
        // SetList::DEAD_CODE,
        // SetList::PHP_80,

        $containerConfigurator->import(WorksomeSetList::LARAVEL_CODE_QUALITY);

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
        $services->set(RemoveDelegatingParentCallRector::class);
        $services->set(RemoveUselessParamTagRector::class);
        $services->set(RemoveUselessReturnTagRector::class);
        $services->set(RemoveNonExistingVarAnnotationRector::class);

        // PHP 80 set rules
        $services->set(ClassPropertyAssignToConstructorPromotionRector::class);

        // Naming set rules
        // $services->set(\Rector\Naming\Rector\Property\UnderscoreToCamelCasePropertyNameRector::class);
    }
}