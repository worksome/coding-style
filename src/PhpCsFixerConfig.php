<?php

namespace Worksome\CodingStyle;

use Generator;
use PhpCsFixer\Config;
use PhpCsFixer\ConfigInterface;
use PhpCsFixer\Fixer\FixerInterface;

class PhpCsFixerConfig extends Config
{
    public const RULE_DEFINITIONS = [
        '@worksome' => [
            'phpdoc_align' => [
                'align' => 'vertical',
            ],
            'phpdoc_separation' => true,
            'ordered_imports' => [
                'imports_order' => [
                    'class',
                    'function',
                    'const',
                ],
                'sort_algorithm' => 'alpha',
            ],
            'operator_linebreak' => [
                'only_booleans' => true,
            ],
            'Worksome/space_in_generics' => true,
        ],
        '@worksome:risky' => [
            // ...
        ],
    ];

    public const CUSTOM_FIXERS = [
        PhpCsFixer\SpaceInGenericsFixer::class,
    ];

    public function __construct()
    {
        parent::__construct('Worksome');

        $this->registerCustomFixers($this->fixers());
    }

    public static function make(): self
    {
        return new self();
    }

    public function setRules(array $rules): ConfigInterface
    {
        foreach (array_keys(self::RULE_DEFINITIONS) as $key) {
            if (($rules[$key] ?? false)) {
                unset($rules[$key]);
                $rules = array_merge(self::RULE_DEFINITIONS[$key], $rules);
            }
        }

        return parent::setRules($rules);
    }

    protected function fixers(): Generator
    {
        foreach (self::CUSTOM_FIXERS as $className) {
            $fixer = new $className();
            assert($fixer instanceof FixerInterface);

            yield $fixer;
        }
    }
}
