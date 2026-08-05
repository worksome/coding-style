<?php

namespace Worksome\CodingStyle;

use Rector\Config\RectorConfig;
use Rector\Configuration\RectorConfigBuilder;
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
use Rector\Php81\Rector\Property\ReadOnlyPropertyRector;
use Worksome\CodingStyle\Rector\WorksomeSetList;

class WorksomeRectorConfig
{
    public static function configure(bool $larastan = true): RectorConfigBuilder
    {
        $phpstanConfig = getcwd() . '/phpstan.neon';

        return RectorConfig::configure()
            ->withPHPStanConfigs(match (true) {
                file_exists($phpstanConfig) => [getcwd() . '/phpstan.neon'],
                $larastan => [getcwd() . '/vendor/larastan/larastan/extension.neon'],
                default => [],
            })
            ->withBootstrapFiles(
                $larastan ? [getcwd() . '/vendor/larastan/larastan/bootstrap.php'] : []
            )
            ->withSets([
                WorksomeSetList::GENERIC_CODE_QUALITY,
                WorksomeSetList::LARAVEL_CODE_QUALITY,
            ])
            ->withRules([
                ClassOnObjectRector::class,
                ClassPropertyAssignToConstructorPromotionRector::class,
                ReadOnlyPropertyRector::class,
                RemoveNonExistingVarAnnotationRector::class,
                RemoveUnreachableStatementRector::class,
                RemoveUnusedVariableInCatchRector::class,
                RemoveUselessParamTagRector::class,
                RemoveUselessReturnTagRector::class,
                StrContainsRector::class,
                StrEndsWithRector::class,
                StrStartsWithRector::class,
            ]);
    }
}
