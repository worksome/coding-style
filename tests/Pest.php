<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

use Illuminate\Support\Str;
use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Files\LocalFile;
use PHP_CodeSniffer\Runner;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHPUnit\Framework\Assert;
use Worksome\CodingStyle\Tests\PhpCsFixer\BasePhpCsFixerTestCase;
use Worksome\CodingStyle\Tests\PHPStan\BaseRuleTestCase;
use Worksome\CodingStyle\Tests\Rector\BaseRectorTestCase;
use Worksome\CodingStyle\Tests\Sniffs\BaseSniffTestCase;

uses(BasePhpCsFixerTestCase::class)->in('PhpCsFixer');
uses(BaseRuleTestCase::class)->in('PHPStan');
uses(BaseRectorTestCase::class)->in('Rector');
uses(BaseSniffTestCase::class)->in('Sniffs');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toHaveRuleErrors', function (array $errors) {
    test()->analyse(
        [
            $this->value
        ],
        $errors,
    );
});

expect()->extend('toHaveNoSniffErrors', function () {
    /** @var \PHP_CodeSniffer\Files\File $value */
    $value = $this->value;

    Assert::assertEmpty(
        $value->getErrors(),
        'The following errors were found: ' . PHP_EOL . json_encode($value->getErrors())
    );

    return $this;
});

expect()->extend('toHaveSniffErrors', function (int $count) {
    /** @var \PHP_CodeSniffer\Files\File $value */
    $value = $this->value;

    Assert::assertCount($count, $value->getErrors());

    return $this;
});

expect()->extend('toHaveSniffError', function (int $line) {
    /** @var \PHP_CodeSniffer\Files\File $value */
    $value = $this->value;

    $errors = $value->getErrors();
    Assert::assertTrue(isset($errors[$line]), sprintf('Expected error on line %s, but none found.', $line));

    $sniffCode = sprintf('%s.%s', getSniffName(test()->sniff), test()->sniff);

    Assert::assertTrue(
        hasError($errors[$line], $sniffCode),
        sprintf(
            'Expected error %s, but none found on line %d.%sErrors found on line %d:%s%s%s',
            $sniffCode,
            $line,
            PHP_EOL . PHP_EOL,
            $line,
            PHP_EOL,
            getFormattedErrors($errors[$line]),
            PHP_EOL
        )
    );

    return $this;
});

expect()->extend('toMatchFixed', function (string $fixedFilePath) {
    $this->value->disableCaching();
    $this->value->fixer->fixFile();

    Assert::assertEquals(file_get_contents($fixedFilePath), $this->value->fixer->getContents());

    return $this;
});


/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function checkFile(string $filePath, array $sniffProperties = []): LocalFile
{
    $sniffClassName = test()->sniff;

    $codeSniffer = new Runner();
    $codeSniffer->config = new Config(array_merge(['-s'], []));
    $codeSniffer->init();

    if (count($sniffProperties) > 0) {
        $codeSniffer->ruleset->ruleset[getSniffName($sniffClassName)]['properties'] = $sniffProperties;
    }

    /** @var Sniff $sniff */
    $sniff = new $sniffClassName();

    $codeSniffer->ruleset->sniffs = [$sniffClassName => $sniff];

    $codeSniffer->ruleset->populateTokenListeners();

    $file = new LocalFile($filePath, $codeSniffer->ruleset, $codeSniffer->config);
    $file->process();

    return $file;
}

function getSniffName(string $sniffClassName): string
{
    $dotted = preg_replace(
        [
            '~\\\\~',
            '~\.Sniffs~',
            '~Sniff$~',
        ],
        [
            '.',
            '',
            '',
        ],
        $sniffClassName
    );

    return Str::after($dotted, 'Worksome.');
}

function hasError(array $errorsOnLine, string $sniffCode): bool
{
    $hasError = false;

    foreach ($errorsOnLine as $errorsOnPosition) {
        foreach ($errorsOnPosition as $error) {
            /** @var string $errorSource */
            $errorSource = $error['source'];

            if ($errorSource === $sniffCode) {
                $hasError = true;
                break;
            }
        }
    }

    return $hasError;
}


function getFormattedErrors(array $errors): string
{
    return implode(PHP_EOL, array_map(static function (array $errors): string {
        return implode(PHP_EOL, array_map(static function (array $error): string {
            return sprintf("\t%s: %s", $error['source'], $error['message']);
        }, $errors));
    }, $errors));
}
