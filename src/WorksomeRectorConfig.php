<?php

namespace Worksome\CodingStyle;

use PHPStan\ExtensionInstaller\GeneratedConfig;
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
    public static function configure(): RectorConfigBuilder
    {
        $larastan = class_exists(
            GeneratedConfig::class
        )
            ? GeneratedConfig::EXTENSIONS['larastan/larastan'] ?? null
            : null;

        return RectorConfig::configure()
            ->withPHPStanConfigs(self::phpstanExtensionConfigs())
            ->withBootstrapFiles(
                $larastan !== null ? [$larastan['install_path'] . '/bootstrap.php'] : []
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

    /**
     * Rector does not load extensions registered by phpstan/extension-installer, so they are passed explicitly.
     *
     * @return list<string>
     */
    private static function phpstanExtensionConfigs(): array
    {
        if (! class_exists(GeneratedConfig::class)) {
            return [];
        }

        $configs = [];

        foreach (GeneratedConfig::EXTENSIONS as $extension) {
            foreach ($extension['extra']['includes'] ?? [] as $include) {
                $configs[] = $extension['install_path'] . '/' . $include;
            }
        }

        return $configs;
    }
}
