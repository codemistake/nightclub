<?php

namespace Tests\Unit\Module\Nightclub\Vo\Guest;

use App\Module\Nightclub\Vo\BodyAction\BodyVo;
use App\Module\Nightclub\Vo\BodyAction\HandVo;
use App\Module\Nightclub\Vo\BodyAction\HeadVo;
use App\Module\Nightclub\Vo\BodyAction\LegVo;
use App\Module\Nightclub\Vo\Dance\DanceStyleVo;
use App\Module\Nightclub\Vo\Genre\GenreVo;
use App\Module\Nightclub\Vo\Guest\GuestResolverVo;
use App\Module\Nightclub\Vo\Guest\GuestVo;
use PHPUnit\Framework\TestCase;

/**
 * Class GuestResolverVoTest
 * @package Tests\Unit\Module\Nightclub\Vo\Guest
 */
class GuestResolverVoTest extends TestCase
{
    /**
     * @throws \ReflectionException
     */
    public function testSuccessGuestResolve(): void
    {
        //arrange
        $rnbGenre = new GenreVo(['name' => 'R&B',]);
        $hipHopGenre = new GenreVo(['name' => 'Hip-hop',]);
        $electrohouseGenre = new GenreVo(['name' => 'Electrohouse',]);

        $firstGuest = new GuestVo([
            'firstName' => 'Ilya',
            'lastName' => 'Popov',
            'danceGenreList' => [
                $electrohouseGenre,
            ],
        ]);
        $secondGuest = new GuestVo([
            'firstName' => 'Ivan',
            'lastName' => 'Emelin',
            'danceGenreList' => [
                $hipHopGenre,
            ],
        ]);
        $thirdGuest = new GuestVo([
            'firstName' => 'Dmitry',
            'lastName' => 'Potapenko',
            'danceGenreList' => [
                $rnbGenre,
            ],
        ]);

        $firstDanceStyle = new DanceStyleVo([
            'name' => $hipHopGenre->getName(),
            'acceptedGenreList' => [
                $electrohouseGenre,
                $rnbGenre,
            ],
            'headAction' => HeadVo::withPassiveStyle(),
            'bodyAction' => BodyVo::withSlowBodyShaking(),
            'handAction' => HandVo::withSlowStyle(),
            'legAction' => LegVo::withFlexStyle(),
        ]);

        $guestList = [
            $firstGuest,
            $secondGuest,
            $thirdGuest,
        ];

        // action
        $guestResolver = new GuestResolverVo($guestList, $firstDanceStyle);

        //assert
        self::assertEquals($guestResolver->getDancingGuestList(), [$firstGuest, $thirdGuest]);
        self::assertEquals($guestResolver->getDrinkingGuestList(), [$secondGuest]);
    }
}
