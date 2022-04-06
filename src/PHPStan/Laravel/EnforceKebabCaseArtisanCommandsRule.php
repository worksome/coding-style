<?php

namespace Worksome\CodingStyle\PHPStan\Laravel;

use Illuminate\Console\Command;
use Illuminate\Console\Parser;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\ClassPropertyNode;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\ShouldNotHappenException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * @implements Rule<Class_>
 */
class EnforceKebabCaseArtisanCommandsRule implements Rule
{
    public function __construct(private array $excludedCommandClasses = [])
    {
    }

    public function getNodeType(): string
    {
        return Class_::class;
    }

    /**
     * @param Class_ $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if ($node->namespacedName === null) {
            return [];
        }

        $className = $node->namespacedName->toString();

        if (! $node->extends || !str_contains($node->extends->toString(), Command::class)) {
            return [];
        }

        if (in_array($className, $this->excludedCommandClasses)) {
            return [];
        }

        if (($property = $node->getProperty('signature')) === null) {
            return [];
        }

        return $this->getCommandSignatureErrors($className, $property);
    }

    public function getCommandSignatureErrors(string $className, Property $signature): array
    {
        $value = (string) $signature->props[0]->default->value;
        $errors = [];
        $command = Parser::parse((string) $value);

        foreach ($command as $segment) {
            if ($segment === []) {
                continue;
            }

            if (is_string($segment)) {
                $errors = $this->getCommandNameErrors($segment, $className, $signature, $errors);
            }

            if (is_array($segment)) {
                $errors = $this->getOptionOrArgumentErrors($segment, $className, $signature, $errors);
            }
        }

        return $errors;
    }

    public function getCommandNameErrors(string $segment, string $className, Property $signature, array $errors): array
    {
        if (!preg_match('/^[a-z0-9\-:]+$/', $segment)) {
            $errors[] = RuleErrorBuilder::message(
                "Command \"{$className}\" is not using kebab-case for the command name in its signature."
            )->line($signature->getLine())->build();
        }

        return $errors;
    }

    public function getOptionOrArgumentErrors(array $segment, string $className, Property $signature, array $errors): array
    {
        foreach ($segment as $optionOrArgument) {
            $isArgument = $optionOrArgument instanceof InputArgument;
            $isOption = $optionOrArgument instanceof InputOption;

            if (!$isArgument && !$isOption) {
                continue;
            }

            $type = $isArgument ? 'argument' : 'option';

            if (!preg_match('/^[a-z0-9\-]+$/', $optionOrArgument->getName())) {
                $errors[] = RuleErrorBuilder::message(
                    "Command \"{$className}\" is not using kebab-case for the \"{$optionOrArgument->getName()}\" {$type} in its signature."
                )->line($signature->getLine())->build();
            }
        }

        return $errors;
    }
}
