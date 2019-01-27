<?php

namespace Swark\Commands;

use Shopware\Commands\ShopwareCommand;
use Swark\Services\OrderService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class CheckTransactionsCommand
 */
class CheckTransactionsCommand extends ShopwareCommand
{
    /**
     * @var OrderService
     */
    private $orderService;

    /**
     * @param OrderService $orderService
     *
     * @throws \Symfony\Component\Console\Exception\LogicException
     */
    public function __construct(OrderService $orderService)
    {
        parent::__construct();

        $this->orderService = $orderService;
    }

    /**
     * @throws \InvalidArgumentException
     */
    protected function configure()
    {
        $this->setName('swark:check:transactions');
        $this->setDescription('Checks transactions and update order state.');
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
            $success = $this->orderService->checkTransactions();
        } catch (\Exception $e) {
            $io->error($e->getMessage());

            return false;
        }

        if ($success) {
            $io->success('Transactions checked and Orders updated. Check plugin logs!');
        } else {
            $io->note('No open orders!');
        }
    }
}
