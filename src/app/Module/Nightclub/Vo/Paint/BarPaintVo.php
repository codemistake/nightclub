<?php

namespace App\Module\Nightclub\Vo\Paint;

/**
 * Class BarPaintVo
 * @package App\Module\Nightclub\Vo\Paint
 */
class BarPaintVo extends BasePaintVo
{
    /**
     * BarPaintVo constructor.
     *
     * @param DrinkingGuestPaintVo[] $guestPaintList
     * @param int $guestInRow
     */
    public function __construct(
        array $guestPaintList,
        int $guestInRow
    ) {
        $guestPaintChunkList = array_chunk($guestPaintList, $guestInRow);

        $preparedRowList = [
            'Бар',
            ' ',
        ];
        $maxWidth = 0;
        foreach ($guestPaintChunkList as $guestPaintChunk) {
            for ($rowIndex = 0; $rowIndex < DrinkingGuestPaintVo::GUEST_BLOCK_HEIGHT; $rowIndex++) {
                $rowContent = '';
                /** @var DancingGuestPaintVo $guestPaint */
                foreach ($guestPaintChunk as $guestPaint) {
                    $rowContent .= $guestPaint->getGuestPaintRowList($rowIndex);
                }
                $preparedRowList[] = $rowContent;
                $rowLength = \mb_strlen($rowContent);
                if ($rowLength > $maxWidth) {
                    $maxWidth = $rowLength;
                }
            }
        }

        $preparedRowList = $this->padRowListToMaxRowWidth($preparedRowList, false);
        $this->paintContent = implode($preparedRowList, PHP_EOL);
    }
}
