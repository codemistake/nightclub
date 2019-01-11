<?php

namespace App\Core\Command;

use App\Core\Measurement\Measurable;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class BaseCommand
 * @package App\Core\Command
 */
abstract class BaseCommand extends Command
{
    use Measurable;

    /**
     * Run the console command.
     *
     * @param  InputInterface $input
     * @param  OutputInterface $output
     *
     * @return int
     *
     * @throws \Exception
     */
    public function run(InputInterface $input, OutputInterface $output): int
    {
        $originVerbosity = $output->getVerbosity();

        $output->setVerbosity(OutputInterface::VERBOSITY_VERBOSE);

        $result = parent::run($input, $output);

        $output->setVerbosity($originVerbosity);

        return $result;
    }
}
