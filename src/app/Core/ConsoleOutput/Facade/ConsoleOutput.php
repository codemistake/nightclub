<?php

namespace App\Core\ConsoleOutput\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static writeln($messages, $options = 0);
 */
class ConsoleOutput extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return "consoleOutput";
    }
}
