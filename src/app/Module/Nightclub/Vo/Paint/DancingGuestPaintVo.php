<?php

namespace App\Module\Nightclub\Vo\Paint;

use App\Module\Nightclub\Vo\BodyAction\BodyVo;
use App\Module\Nightclub\Vo\BodyAction\HeadVo;
use App\Module\Nightclub\Vo\GuestVo;

/**
 * Class DancingGuestPaintVo
 * @package App\Module\Nightclub\Vo\Paint
 */
class DancingGuestPaintVo extends BasePaintVo
{
    private const DEFAULT_GUEST_STATE = [
        '     ',
        '     ',
        '     ',
    ];
    public const GUEST_BLOCK_HEIGHT = 5;
    /** @var string[] */
    private $guestPaintRowList;

    /**
     * DancingGuestPaintVo constructor.
     *
     * @param GuestVo $guestVo
     * @param string[] $headAction
     * @param string[] $bodyAction
     * @param string[] $legAction
     * @param string[] $leftHandAction
     * @param string[] $rightHandAction
     */
    public function __construct(
        GuestVo $guestVo,
        array $headAction,
        array $bodyAction,
        array $legAction,
        array $leftHandAction,
        array $rightHandAction
    ) {
        $actionSetList = [
            $headAction,
            $bodyAction,
            $legAction,
            $leftHandAction,
            $rightHandAction,
        ];

        $guestPaintRowList = self::DEFAULT_GUEST_STATE;
        foreach ($actionSetList as $actionSet) {
            $currentRow = 0;
            foreach ($actionSet as $rowKey => $rowAction) {
                $characterInRowList = preg_split('//u', $rowAction, -1, PREG_SPLIT_NO_EMPTY);

                foreach ($characterInRowList as $columnIndex => $rowCharacter) {
                    if ($rowCharacter !== ' ') {
                        $guestPaintRowList[$currentRow] = $this->replaceCharterInString(
                            $guestPaintRowList[$currentRow],
                            $rowCharacter,
                            $columnIndex,
                            1
                        );
                    }
                }
                if (
                    $currentRow === BodyVo::BODY_CENTER_ROW_INDEX &&
                    $rowAction === BodyVo::THROWS_FORWARD_STATE[1]
                ) {
                    $guestPaintRowList[HeadVo::HEAD_ROW_INDEX] = mb_substr(
                            $guestPaintRowList[HeadVo::HEAD_ROW_INDEX],
                            1
                        ) . ' ';
                }

                if (
                    $currentRow === BodyVo::BODY_CENTER_ROW_INDEX &&
                    $rowAction === BodyVo::THROWS_BACK_STATE[1]
                ) {
                    $guestPaintRowList[HeadVo::HEAD_ROW_INDEX] = ' ' . mb_substr(
                            $guestPaintRowList[HeadVo::HEAD_ROW_INDEX],
                            0,
                            -1
                        );
                }
                $currentRow++;
            }
        }

        $guestPaintRowList[] = $guestVo->getFirstName();
        $guestPaintRowList[] = $guestVo->getLastName();
        $guestPaintRowList[] = PHP_EOL;

        $this->guestPaintRowList = $this->padRowListToMaxRowWidth($guestPaintRowList, 6);
    }

    /**
     * @param string $originalRow
     * @param string $character
     * @param int $position
     * @param int $length
     *
     * @return string
     */
    private function replaceCharterInString(
        string $originalRow,
        string $character,
        int $position,
        int $length
    ): string {
        $startString = mb_substr($originalRow, 0, $position, 'UTF-8');
        $endString = mb_substr($originalRow, $position + $length, mb_strlen($originalRow), 'UTF-8');

        return $startString . $character . $endString;
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
