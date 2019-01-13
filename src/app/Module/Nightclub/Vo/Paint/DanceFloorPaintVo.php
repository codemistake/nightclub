<?php

namespace App\Module\Nightclub\Vo\Paint;

/**
 * Class DanceFloorPaintVo
 * @package App\Module\Nightclub\Vo\Paint
 */
class DanceFloorPaintVo extends BasePaintVo
{
    /**
     * DanceFloorPaintVo constructor.
     *
     * @param DancingGuestPaintVo[] $guestPaintList
     * @param int $guestInRow
     */
    public function __construct(
        array $guestPaintList,
        int $guestInRow
    ) {
        $guestPaintChunkList = array_chunk($guestPaintList, $guestInRow);

        $preparedRowList = [
            'Танцпол',
            ' ',
        ];
        foreach ($guestPaintChunkList as $guestPaintChunk) {
            for ($rowIndex = 0; $rowIndex < DancingGuestPaintVo::GUEST_BLOCK_HEIGHT; $rowIndex++) {
                $rowContent = '';
                /** @var DancingGuestPaintVo $guestPaint */
                foreach ($guestPaintChunk as $guestPaint) {
                    $rowContent .= $guestPaint->getRowByKey($rowIndex);
                }
                $preparedRowList[] = $rowContent;
            }
        }

        $this->paintContent = implode($preparedRowList, PHP_EOL);
    }
}
