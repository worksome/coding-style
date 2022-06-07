<?php

namespace Worksome\CodingStyle;

use PhpCsFixer\Config;
use PhpCsFixer\ConfigInterface;

class PhpCsFixerConfig extends Config
{
    const RULE_DEFINITIONS = [
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
        ],
        '@worksome:risky' => [
            // ...
        ],
    ];

    public function __construct()
    {
        parent::__construct('Worksome');
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
}
