<?php

namespace Swark\Commands;

use Shopware\Commands\ShopwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class TestConfigurationCommand
 */
class TestConfigurationCommand extends ShopwareCommand
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws \InvalidArgumentException
     */
    protected function configure()
    {
        $this->setName('swark:test:configuration');
        $this->setDescription('Tests the configuration and important interfaces that must work.');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return bool
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        try {
            // TODO: Implement Check Command
            // connection test and if a transaction can be searched by vendorField
            // check if exchange rate can be crawled and updated
            // check if wallet address can be randomly selected
        } catch (\Exception $e) {
            $io->error($e->getMessage());

            return false;
        }

        $io->success('Transactions checked and updated. Check plugin logs!');

        return true;
    }
}
