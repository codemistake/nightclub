<?php

namespace App\Module\Nightclub\Vo\GuestResolver;

use App\Module\Nightclub\Vo\Dance\DanceStyleVo;
use App\Module\Nightclub\Vo\Guest\GuestVo;

/**
 * Class GuestResolverVo
 * @package App\Module\Nightclub\Vo\GuestResolver
 */
class GuestResolverVo
{
    /** @var GuestVo[] */
    private $dancingGuestList;
    /** @var GuestVo[] */
    private $drinkingGuestList;

    /**
     * GuestResolverVo constructor.
     *
     * @param array $guestList
     * @param DanceStyleVo $danceStyleVo
     */
    public function __construct(
        array $guestList,
        DanceStyleVo $danceStyleVo
    ) {
        $dancingGuestList = [];
        $drinkingGuestList = [];

        /** @var GuestVo $guestVo */
        foreach ($guestList as $guestVo) {
            if ($this->guestCanDanceCurrentStyle($guestVo, $danceStyleVo)) {
                $dancingGuestList[] = $guestVo;
                continue;
            }
            $drinkingGuestList[] = $guestVo;
        }

        $this->dancingGuestList = $dancingGuestList;
        $this->drinkingGuestList = $drinkingGuestList;
    }

    /**
     * @param \App\Module\Nightclub\Vo\Guest\GuestVo $guestVo
     * @param DanceStyleVo $danceStyleVo
     *
     * @return bool
     */
    private function guestCanDanceCurrentStyle(GuestVo $guestVo, DanceStyleVo $danceStyleVo): bool
    {
        foreach ($danceStyleVo->getAcceptedGenreList() as $acceptedGenre) {
            foreach ($guestVo->getDancingGenreList() as $guestDancingGenre) {
                if ($acceptedGenre->getName() === $guestDancingGenre->getName()) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @return GuestVo[]
     */
    public function getDancingGuestList(): array
    {
        return $this->dancingGuestList;
    }

    /**
     * @return GuestVo[]
     */
    public function getDrinkingGuestList(): array
    {
        return $this->drinkingGuestList;
    }
}
