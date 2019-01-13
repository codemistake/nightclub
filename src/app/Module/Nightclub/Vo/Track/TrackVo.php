<?php

namespace App\Module\Nightclub\Vo\Track;

use App\Module\Nightclub\Vo\Genre\GenreVo;
use SimpleDto\SimpleDto;

/**
 * Class TrackVo
 * @package App\Module\Nightclub\Vo\Track
 */
class TrackVo extends SimpleDto
{
    /** @var string */
    private $author;
    /** @var string */
    private $name;
    /** @var int */
    private $duration;
    /** @var \App\Module\Nightclub\Vo\Genre\GenreVo */
    private $genre;

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
     * @return GenreVo
     */
    public function getGenre(): GenreVo
    {
        return $this->genre;
    }
}
