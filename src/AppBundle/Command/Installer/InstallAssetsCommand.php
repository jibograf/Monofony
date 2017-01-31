<?php

namespace AppBundle\Command\Installer;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class InstallAssetsCommand extends AbstractInstallCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:install:assets')
            ->setDescription('Installs all Alcéane assets.')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command downloads and installs all Alcéane media assets.
EOT
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf('Installing Alcéane assets for environment <info>%s</info>.', $this->getEnvironment()));

        try {
            $this->ensureDirectoryExistsAndIsWritable(self::WEB_ASSETS_DIRECTORY, $output);
            $this->ensureDirectoryExistsAndIsWritable(self::WEB_BUNDLES_DIRECTORY, $output);
        } catch (\RuntimeException $exception) {
            return 1;
        }

        $commands = [
            'assets:install',
            'assetic:dump',
        ];

        $this->runCommands($commands, $output);
    }
}
