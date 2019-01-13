<?php

namespace App\Module\Nightclub\Vo\Genre;

use SimpleDto\SimpleDto;

/**
 * Class GenreVo
 * @package App\Module\Nightclub\Vo\Genre
 */
class GenreVo extends SimpleDto
{
    /** @var string */
    private $name;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}