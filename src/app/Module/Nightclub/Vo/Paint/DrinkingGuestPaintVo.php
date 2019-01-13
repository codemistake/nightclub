<?php

namespace App\Module\Nightclub\Vo\Paint;

use App\Module\Nightclub\Vo\Guest\GuestVo;

/**
 * Class DrinkingGuestPaintVo
 * @package App\Module\Nightclub\Vo\Paint
 */
class DrinkingGuestPaintVo extends BasePaintVo
{
    private const DEFAULT_GUEST_STATE = [
        ' 0   ',
        ' | _ ',
        ' П \ ',
    ];
    private const DRINKING_VODKA_STATE = [
        ' 0 \ ',
        ' |   ',
        ' П \ ',
    ];
    public const GUEST_BLOCK_HEIGHT = 5;
    /** @var string[] */
    private $guestPaintRowList;

    /**
     * DancingGuestPaintVo constructor.
     *
     * @param GuestVo $guestVo
     * @param bool $isWannaDrink
     */
    public function __construct(
        GuestVo $guestVo,
        bool $isWannaDrink
    ) {
        $guestPaintRowList = $isWannaDrink ? self::DRINKING_VODKA_STATE : self::DEFAULT_GUEST_STATE;
        $guestPaintRowList[] = $guestVo->getFirstName();
        $guestPaintRowList[] = $guestVo->getLastName();
        $guestPaintRowList[] = PHP_EOL;

        $this->guestPaintRowList = $this->padRowListToMaxRowWidth($guestPaintRowList, 6);
    }

    /**
     * @param int $rowId
     *
     * @return string
     */
    public function getGuestPaintRowList(int $rowId): string
    {
        return $this->guestPaintRowList[$rowId] ?? '';
    }
}
