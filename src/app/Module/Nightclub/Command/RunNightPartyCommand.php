<?php

namespace App\Module\Nightclub\Command;

use App\Core\Command\BaseCommand;

/**
 * Class RunNightPartyCommand
 * @package App\Module\Nightclub\Command
 */
class RunNightPartyCommand extends BaseCommand
{
    private const SIGNATURE = 'nightclub:start';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = self::SIGNATURE;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start party in nightclub';

    public function handle(): void
    {
        var_dump('111');
    }
}
