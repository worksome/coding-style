<?php

namespace Worksome\CodingStyle;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName("generate-coding-style-stubs");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Worksome's Coding style has 3 stub files (phpcs, phpstan and rector)");

        $files = [
            'php-cs-fixer.dist.php' => __DIR__ . '/../stubs/php-cs-fixer.dist.php.stub',
            'phpcs.xml' => __DIR__ . '/../stubs/phpcs.xml.stub',
            'phpstan.neon' => __DIR__ . '/../stubs/phpstan.neon.stub',
            'rector.php' => __DIR__ . '/../stubs/rector.php.stub',
        ];

        foreach ($files as $newFile => $oldFile) {
            $path = sprintf("%s/%s", getcwd(), $newFile);
            if (file_exists($path)) {
                $output->writeln("$newFile already exist. Skipping...");
                continue;
            }

            copy($oldFile, $path);
            $output->writeln("Generated $newFile.");
        }

        $this->getComposer()->getConfig()->merge([
            'scripts' => [
                "phpcs" => "vendor/bin/phpcs",
                "php-cs-fixer" => "vendor/bin/php-cs-fixer fix --ansi",
                "php-cs-fixer-ci" => "vendor/bin/php-cs-fixer fix --dry-run --ansi",
                "phpcbf" => "vendor/bin/phpcbf",
                "phpstan" => "vendor/bin/phpstan analyse",
                "rector-ci" => "vendor/bin/rector process --dry-run --ansi",
                "rector" => "vendor/bin/rector process --ansi",
            ]
        ]);
    }
}