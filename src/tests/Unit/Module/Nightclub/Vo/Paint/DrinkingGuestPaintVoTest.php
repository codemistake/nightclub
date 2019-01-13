<?php

namespace Tests\Unit\Module\Nightclub\Vo\Paint;

use App\Module\Nightclub\Vo\Genre\GenreVo;
use App\Module\Nightclub\Vo\Guest\GuestVo;
use App\Module\Nightclub\Vo\Paint\DrinkingGuestPaintVo;
use PHPUnit\Framework\TestCase;

/**
 * Class DrinkingGuestPaintVoTest
 * @package Tests\Unit\Module\Nightclub\Vo
 */
class DrinkingGuestPaintVoTest extends TestCase
{
    /**
     * @throws \ReflectionException
     */
    public function testSuccessGuestWannaDrink(): void
    {
        // arrange
        $firstName = 'Ilya';
        $secondName = 'Popov';
        $guestVo = new GuestVo([
            'firstName' => $firstName,
            'lastName' => $secondName,
            'danceGenreList' => [
                new GenreVo(['name' => 'R&B',]),
            ],
        ]);

        $rightGuestPaintedImage = [
            '    0 \    ',
            '    | ‾    ',
            '    П \    ',
            $firstName,
            $secondName,
        ];

        // action
        $drinkingGuestVo = new DrinkingGuestPaintVo(
            $guestVo,
            true
        );

        //assert
        foreach ($rightGuestPaintedImage as $rowId => $rowValue) {
            self::assertSame(trim($drinkingGuestVo->getRowByKey($rowId)), trim($rowValue));
        }
    }

    /**
     * @throws \ReflectionException
     */
    public function testSuccessGuestDoestWontDrink(): void
    {
        // arrange
        $firstName = 'Ilya';
        $secondName = 'Popov';
        $guestVo = new GuestVo([
            'firstName' => $firstName,
            'lastName' => $secondName,
            'danceGenreList' => [
                new GenreVo(['name' => 'R&B',]),
            ],
        ]);

        $rightGuestPaintedImage = [
            '    0      ',
            '    | _    ',
            '    П \    ',
            $firstName,
            $secondName,
        ];

        // action
        $drinkingGuestVo = new DrinkingGuestPaintVo(
            $guestVo,
            false
        );

        //assert
        foreach ($rightGuestPaintedImage as $rowId => $rowValue) {
            self::assertSame(trim($drinkingGuestVo->getRowByKey($rowId)), trim($rowValue));
        }
    }
}
