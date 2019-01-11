<?php

namespace App\Module\Nightclub\Provider;

use App\Module\Nightclub\Command\RunNightPartyCommand;
use Illuminate\Support\ServiceProvider;

/**
 * Class CommandProvider
 *
 * @package App\Module\BroadcastGridStat\Provider
 */
class CommandProvider extends ServiceProvider
{
    /** @var array */
    private $commandList = [
            RunNightPartyCommand::class,
    ];

    public function boot(): void
    {
        $this->commands($this->commandList);
    }
}
