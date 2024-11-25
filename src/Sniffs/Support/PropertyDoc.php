<?php

declare(strict_types=1);

namespace Worksome\CodingStyle\Sniffs\Support;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Worksome\CodingStyle\Utility;

final readonly class PropertyDoc
{
    public function __construct(
        private string $scope,
        private string|null $types,
        private string $variableName,
        private string|null $description,
    ) {
    }

    public static function from(string $content): self
    {
        if (! str_starts_with($content, '@property')) {
            throw new InvalidArgumentException('Valid property docs must start with a @property tag.');
        }

        [$scope, $detail] = explode(' ', $content, 2);

        $typeMatches = [];

        Utility::preg_match(self::regexForTypes(), $detail, $typeMatches);

        $types = $typeMatches[0];
        $remainderAfterType = Str::of($detail)->after($types)->trim();

        if ($remainderAfterType->isNotEmpty()) {
            $variable = $remainderAfterType->before(' ')->__toString();
            $description = $remainderAfterType->after(' ')->__toString();
        } else {
            $types = null;
            $variable = $typeMatches[0];
            $description = null;
        }

        if (str_starts_with($types ?? '', '$')) {
            $description = $variable;
            $variable = $types;
            $types = null;
        }

        return new self(
            $scope,
            $types,
            $variable,
            $description !== $variable ? $description : null,
        );
    }

    public function variableHasDollarSymbol(): bool
    {
        return str_starts_with($this->variableName, '$');
    }

    public function joined(): string
    {
        return join(' ', array_filter([
            $this->scope,
            $this->types,
            Str::start($this->variableName, '$'),
            $this->description,
        ]));
    }

    private static function regexForTypes(): string
    {
        return <<<REGEXP
        /
        (                                       # Capture group #1.
            [$\\\\\w&|-]+                       # Match any word, including words with '$', '\', '&', '|', or '-' symbols.
            (                                   # Capture group #2.
                [\[{<]                          # Match any '<' or '{' symbols, which are used in PHPStan generics.
                (?:[^\[\]{}<>]+|(?2))*+         # Recursively ignore any matching sets of '<' and '>', '{' and '}' or '[' and ']' found in nested types. Eg: `Collection<int, array<string, string>>`.
                [\]}>]                          # Until we match the closing '>' or '}'.
            )?                                  # End capture group #2. Not all types are generics, so capture group 2 is optional.
        )                                       # End capture group #1.
        (                                       # Capture group #3.
            (?:\s?\|\s?)(?1)                    # If we find an '|' symbol we expect another type, so we'll recursively check capture group #1 again.
        )*                                      # End capture group #3. There can be 0 or more of this group.
        /x
        REGEXP;
    }
}
