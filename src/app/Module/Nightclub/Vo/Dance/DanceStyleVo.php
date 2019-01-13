<?php

namespace App\Module\Nightclub\Vo\Dance;

use App\Module\Nightclub\Vo\BodyAction\BodyVo;
use App\Module\Nightclub\Vo\BodyAction\HandVo;
use App\Module\Nightclub\Vo\BodyAction\HeadVo;
use App\Module\Nightclub\Vo\BodyAction\LegVo;
use App\Module\Nightclub\Vo\Genre\GenreVo;
use SimpleDto\SimpleDto;

/**
 * Class GenreVo
 * @package App\Module\Nightclub\Vo\Genre
 */
class DanceStyleVo extends SimpleDto
{
    /** @var string */
    private $name;
    /** @var \App\Module\Nightclub\Vo\Genre\GenreVo[] */
    private $acceptedGenreList;
    /** @var \App\Module\Nightclub\Vo\BodyAction\HeadVo */
    private $headAction;
    /** @var \App\Module\Nightclub\Vo\BodyAction\BodyVo */
    private $bodyAction;
    /** @var \App\Module\Nightclub\Vo\BodyAction\HandVo */
    private $handAction;
    /** @var \App\Module\Nightclub\Vo\BodyAction\LegVo */
    private $legAction;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return GenreVo[]
     */
    public function getAcceptedGenreList(): array
    {
        return $this->acceptedGenreList;
    }

    /**
     * @return HeadVo
     */
    public function getHeadAction(): HeadVo
    {
        return $this->headAction;
    }

    /**
     * @return BodyVo
     */
    public function getBodyAction(): BodyVo
    {
        return $this->bodyAction;
    }

    /**
     * @return HandVo
     */
    public function getHandAction(): HandVo
    {
        return $this->handAction;
    }

    /**
     * @return LegVo
     */
    public function getLegAction(): LegVo
    {
        return $this->legAction;
    }
}