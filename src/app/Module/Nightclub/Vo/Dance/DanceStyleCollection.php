<?php

namespace App\Module\Nightclub\Vo\Dance;

/**
 * Class DanceStyleCollection
 * @package App\Module\Nightclub\Vo\Dance
 */
class DanceStyleCollection
{
    /** @var DanceStyleVo[] */
    private $mapByGenreName = [];

    /**
     * DanceStyleCollection constructor.
     *
     * @param DanceStyleVo[] $genreList
     */
    public function __construct(array $genreList)
    {
        foreach ($genreList as $genreVo) {
            $this->mapByGenreName[$genreVo->getName()] = $genreVo;
        }
    }

    /**
     * @param string $genreName
     *
     * @return DanceStyleVo|null
     */
    public function getByName(string $genreName): ?DanceStyleVo
    {
        return $this->mapByGenreName[$genreName] ?? null;
    }

    /**
     * @return DanceStyleVo[]
     */
    public function getList(): array
    {
        return $this->mapByGenreName;
    }
}