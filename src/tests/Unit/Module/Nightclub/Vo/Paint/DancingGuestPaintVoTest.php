<?php

namespace Tests\Unit\Module\Nightclub\Vo\Paint;

use App\Module\Nightclub\Vo\Genre\GenreVo;
use App\Module\Nightclub\Vo\Guest\GuestVo;
use App\Module\Nightclub\Vo\Paint\DancingGuestPaintVo;
use PHPUnit\Framework\TestCase;

/**
 * Class DancingGuestPaintVoTest
 * @package Tests\Unit\Module\Nightclub\Vo
 */
class DancingGuestPaintVoTest extends TestCase
{
    /**
     * @throws \ReflectionException
     */
    public function testSuccessPaintDancingGuest(): void
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
        $headAction = [
            '  0  ',
            '     ',
            '     ',
        ];
        $bodyAction = [
            '     ',
            '  \  ',
            '     ',
        ];
        $legAction = [
            '     ',
            '     ',
            ' / \ ',
        ];
        $leftHandAction = [
            '\    ',
            '     ',
            '     ',
        ];
        $rightHandAction = [
            '    /',
            '     ',
            '     ',
        ];
        $rightGuestPaintedImage = [
            '   \ 0 /   ',
            '     \     ',
            '    / \    ',
            $firstName,
            $secondName,
        ];

        // action
        $dancingGuestVo = new DancingGuestPaintVo(
            $guestVo,
            $headAction,
            $bodyAction,
            $legAction,
            $leftHandAction,
            $rightHandAction
        );

        //assert
        foreach ($rightGuestPaintedImage as $rowId => $rowValue) {
            self::assertSame(trim($dancingGuestVo->getRowByKey($rowId)), trim($rowValue));
        }
    }
}
