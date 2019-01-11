<?php

namespace App\Libs;

class ExtendedXMLReader extends \XMLReader
{
    public function hasValue() : bool
    {
        return $this->hasValue || ($this->read() && $this->nodeType === self::TEXT);
    }

    public function loopUntil($node) : bool
    {
        while ($this->read()) {
            if ($this->name === $node) {
                return true;
            }
        }

        return false;
    }
}