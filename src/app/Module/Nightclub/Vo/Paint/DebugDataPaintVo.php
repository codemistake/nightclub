<?php

namespace App\Module\Nightclub\Vo\Paint;

use App\Module\Nightclub\Vo\Dance\DanceStyleVo;
use App\Module\Nightclub\Vo\Guest\GuestVo;

/**
 * Class DebugDataPaintVo
 * @package App\Module\Nightclub\Vo\Paint
 */
class DebugDataPaintVo extends BasePaintVo
{
    /**
     * DebugDataPaintVo constructor.
     *
     * @param GuestVo[] $guestList
     * @param DanceStyleVo[] $danceStyleList
     */
    public function __construct(
        array $guestList,
        array $danceStyleList
    ) {
        $debugDataList = [];
        foreach ($guestList as $guestVo) {
            $genreNameList = [];
            foreach ($guestVo->getDancingGenreList() as $genreVo) {
                $genreNameList[] = $genreVo->getName();
            }
            $debugRow = "{$guestVo->getFirstName()} {$guestVo->getLastName()}: " . implode(',', $genreNameList);
            $debugDataList[] = $debugRow;
        }

        $debugDataList[] = ' ';
        foreach ($danceStyleList as $danceStyleVo) {
            $acceptedGenreNameList = [];
            foreach ($danceStyleVo->getAcceptedGenreList() as $genreVo) {
                $acceptedGenreNameList[] = $genreVo->getName();
            }
            $debugDataList[] = "{$danceStyleVo->getName()}: " . implode(',', $acceptedGenreNameList);
        }

        $this->paintContent = implode($debugDataList, PHP_EOL);
    }
}
