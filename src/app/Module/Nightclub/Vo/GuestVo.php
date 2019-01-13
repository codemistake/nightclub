<?php

namespace App\Module\Nightclub\Vo;

use App\Module\Nightclub\Vo\Genre\GenreVo;
use SimpleDto\SimpleDto;

/**
 * Class GuestVo
 * @package App\Module\Nightclub\Vo
 */
class GuestVo extends SimpleDto
{
    /** @var string */
    private $firstName;
    /** @var string */
    private $lastName;
    /** @var \App\Module\Nightclub\Vo\Genre\GenreVo[] */
    private $danceGenreNameList = [];

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return GenreVo[]
     */
    public function getDancingGenreList(): array
    {
        return $this->danceGenreNameList;
    }
}
