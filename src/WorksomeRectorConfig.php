<?php

namespace Worksome\CodingStyle;

use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassMethod\RemoveDelegatingParentCallRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\DeadCode\Rector\Node\RemoveNonExistingVarAnnotationRector;
use Rector\DeadCode\Rector\Stmt\RemoveUnreachableStatementRector;
use Rector\Php80\Rector\Catch_\RemoveUnusedVariableInCatchRector;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\Php80\Rector\FuncCall\ClassOnObjectRector;
use Rector\Php80\Rector\Identical\StrEndsWithRector;
use Rector\Php80\Rector\Identical\StrStartsWithRector;
use Rector\Php80\Rector\NotIdentical\StrContainsRector;
use Worksome\CodingStyle\Rector\WorksomeSetList;

class WorksomeRectorConfig
{
    public static function setup(RectorConfig $rectorConfig): void
    {
        $rectorConfig->bootstrapFiles([
            getcwd() . '/vendor/nunomaduro/larastan/bootstrap.php',
        ]);

        $rectorConfig->phpstanConfig(getcwd() . '/phpstan.neon');

        // Define what rule sets will be applied
        // SetList::DEAD_CODE,
        // SetList::PHP_80,

        $rectorConfig->import(WorksomeSetList::LARAVEL_CODE_QUALITY);
        $rectorConfig->import(WorksomeSetList::GENERIC_CODE_QUALITY);

        // Register a single rule
        $rectorConfig->rule(ClassOnObjectRector::class);
        $rectorConfig->rule(StrContainsRector::class);
        $rectorConfig->rule(StrStartsWithRector::class);
        $rectorConfig->rule(StrEndsWithRector::class);
        $rectorConfig->rule(RemoveUnusedVariableInCatchRector::class);

        // DEAD CODE set rules
        $rectorConfig->rule(RemoveUnreachableStatementRector::class);
        $rectorConfig->rule(RemoveDelegatingParentCallRector::class);
        $rectorConfig->rule(RemoveUselessParamTagRector::class);
        $rectorConfig->rule(RemoveUselessReturnTagRector::class);
        $rectorConfig->rule(RemoveNonExistingVarAnnotationRector::class);

        // PHP 8.0 set rules
        $rectorConfig->rule(ClassPropertyAssignToConstructorPromotionRector::class);

        // Naming set rules
        // $rectorConfig->rule(\Rector\Naming\Rector\Property\UnderscoreToCamelCasePropertyNameRector::class);
    }
}
