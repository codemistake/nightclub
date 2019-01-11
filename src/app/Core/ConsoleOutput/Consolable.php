<?php

namespace App\Core\ConsoleOutput;

use App\Core\ConsoleOutput\Facade\ConsoleOutput;

trait Consolable
{
    public function line($string, $style = null)
    {
        $styled = $style ? "<$style>$string</$style>" : $string;

        ConsoleOutput::writeln($styled);
    }

    public function info($string)
    {
        $this->line($string, 'info');
    }

    public function comment($string)
    {
        $this->line($string, 'comment');
    }

    public function question($string)
    {
        $this->line($string, 'question');
    }

    public function error($string)
    {
        $this->line($string, 'error');
    }

    public function warn($string)
    {
        $this->line($string, 'warning');
    }
}
