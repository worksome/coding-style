<?php

declare(strict_types=1);

use PHPStan\ExtensionInstaller\GeneratedConfig;

$larastan = isset(GeneratedConfig::EXTENSIONS['larastan/larastan']);
$larastanStrictRules = $larastan && isset(GeneratedConfig::EXTENSIONS['canvural/larastan-strict-rules']);

return [
    'includes' => [
        __DIR__ . '/phpstan.neon',
        ...($larastan ? [__DIR__ . '/larastan.neon'] : []),
        ...($larastanStrictRules ? [__DIR__ . '/larastan-strict-rules.neon'] : []),
    ],
];
