<?php

namespace App\Module\Nightclub\Vo;

use SimpleDto\SimpleDto;

/**
 * Class TrackVo
 * @package App\Module\Nightclub\Vo
 */
class TrackVo extends SimpleDto
{
    /** @var string */
    private $author;
    /** @var string */
    private $name;
    /** @var int */
    private $duration;
    /** @var string */
    private $genreName;

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @return string
     */
    public function getGenreName(): string
    {
        return $this->genreName;
    }
}