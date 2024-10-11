<?php

namespace Worksome\CodingStyle;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName('generate-coding-style-stubs');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("Worksome's Coding style has 3 stub files (ecs, phpstan and rector)");

        $files = [
            'ecs.php' => __DIR__ . '/../stubs/ecs.php.stub',
            'phpstan.neon' => __DIR__ . '/../stubs/phpstan.neon.stub',
            'rector.php' => __DIR__ . '/../stubs/rector.php.stub',
        ];

        foreach ($files as $newFile => $oldFile) {
            $path = sprintf('%s/%s', getcwd(), $newFile);
            if (file_exists($path)) {
                $output->writeln("$newFile already exist. Skipping...");
                continue;
            }

            copy($oldFile, $path);
            $output->writeln("Generated $newFile.");
        }

        $this->tryComposer()->getConfig()->merge([
            'scripts' => [
                'ecs' => 'vendor/bin/ecs',
                'ecs:fix' => 'vendor/bin/ecs --fix',
                'phpstan' => 'vendor/bin/phpstan analyse',
                'rector' => 'vendor/bin/rector process --dry-run --ansi',
                'rector:fix' => 'vendor/bin/rector process --ansi',
            ]
        ]);

        return BaseCommand::SUCCESS;
    }
}
