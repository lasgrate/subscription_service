<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Ui\Console;

use KiloHealth\Subscription\Application\Command\Importer;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCommand extends Command
{
    protected static $defaultName = 'currency-rate:import';

    public function __construct(private Importer $importer, private LoggerInterface $logger)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption(
            'rateDate', //name
            'd', //shortcut
            InputOption::VALUE_REQUIRED, //mode
        )->addOption(
            'importType', //name
            't', //shortcut
            InputOption::VALUE_REQUIRED, //mode
        )->addOption(
            'volatilityInterval', //name
            'vi', //shortcut
            InputOption::VALUE_REQUIRED, //mode
        )->addOption(
            'volatilityRelativeThreshold', //name
            'vt', //shortcut
            InputOption::VALUE_REQUIRED, //mode
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $rateDate = $input->getOption('rateDate');

        if (!\is_null($rateDate)) {
            $rateDate = new \DateTimeImmutable($rateDate);
        }

        $volatilityInterval = $input->getOption('volatilityInterval');

        if (!\is_null($volatilityInterval)) {
            $volatilityInterval = new \DateInterval($volatilityInterval);
        }

        $volatilityRelativeThreshold = $input->getOption('volatilityRelativeThreshold');

        if (!\is_null($volatilityRelativeThreshold)) {
            $volatilityRelativeThreshold = floatval($volatilityRelativeThreshold);
        }

        try {
            $this->importer->import(
                $rateDate,
                $volatilityInterval,
                $volatilityRelativeThreshold,
                $input->getOption('importType'),
            );
        } catch (\Throwable $exception) {
            $this->logger->emergency('[ImportCommand] Cannot import currency rates', [
                'exception' => $exception,
                'rateDate' => $rateDate,
            ]);
        }

        return Command::SUCCESS;
    }
}
