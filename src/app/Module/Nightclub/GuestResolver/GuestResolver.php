<?php

namespace App\Module\Nightclub\GuestResolver;

use App\Module\Nightclub\Vo\Dance\DanceStyleVo;
use App\Module\Nightclub\Vo\GuestVo;

/**
 * Class GuestResolver
 * @package App\Module\Nightclub\GuestResolver
 */
class GuestResolver
{
    /** @var GuestVo[] */
    private $dancingGuestList;
    /** @var GuestVo[] */
    private $drinkingGuestList;

    /**
     * GuestResolver constructor.
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
     * @param GuestVo $guestVo
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