<?php

namespace App\Module\Nightclub\Vo\Paint;

/**
 * Class BorderedBoxPaintVo
 * @package App\Module\Nightclub\Vo\Paint
 */
class BorderedBoxPaintVo extends BasePaintVo
{
    private const HORIZONTAL_LINE_SYMBOL = '─';
    private const VERTICAL_LINE_SYMBOL = '│';
    private const TOP_LEFT_CORNER_SYMBOL = '┌';
    private const TOP_RIGHT_CORNER_SYMBOL = '┐';
    private const BOTTOM_LEFT_CORNER_SYMBOL = '└';
    private const BOTTOM_RIGHT_CORNER_SYMBOL = '┘';
    private const MINIMUM_BLOCK_WIDTH = 70;

    /**
     * BorderedBoxPaintVo constructor.
     *
     * @param string $content
     * @param int $horizontalPadding
     * @param int $verticalPadding
     */
    public function __construct(
        string $content,
        int $horizontalPadding,
        int $verticalPadding
    ) {
        $contentRowList = explode(PHP_EOL, $content);
        $maxRowLength = self::MINIMUM_BLOCK_WIDTH;
        foreach ($contentRowList as $key => $row) {
            $contentRowList[$key] = $row;
            $rowLength = \mb_strlen($contentRowList[$key]);
            if ($rowLength > $maxRowLength) {
                $maxRowLength = $rowLength;
            }
        }

        $horizontalContentLength = $maxRowLength + ($horizontalPadding * 2);
        $result = [];
        $result[] = self::TOP_LEFT_CORNER_SYMBOL .
            $this->padStringToFixedWidth('', $horizontalContentLength, self::HORIZONTAL_LINE_SYMBOL) .
            self::TOP_RIGHT_CORNER_SYMBOL;

        for ($i = 0; $i < $verticalPadding; $i++) {
            $result[] = self::VERTICAL_LINE_SYMBOL .
                $this->padStringToFixedWidth('', $horizontalContentLength, ' ') .
                self::VERTICAL_LINE_SYMBOL;
        }

        foreach ($contentRowList as $row) {
            $result[] = self::VERTICAL_LINE_SYMBOL .
                $this->padStringToFixedWidth($row, $horizontalContentLength, ' ') .
                self::VERTICAL_LINE_SYMBOL;
        }

        for ($i = 0; $i < $verticalPadding; $i++) {
            $result[] = self::VERTICAL_LINE_SYMBOL .
                $this->padStringToFixedWidth('', $horizontalContentLength, ' ') .
                self::VERTICAL_LINE_SYMBOL;
        }

        $result[] = self::BOTTOM_LEFT_CORNER_SYMBOL .
            $this->padStringToFixedWidth('', $horizontalContentLength, self::HORIZONTAL_LINE_SYMBOL) .
            self::BOTTOM_RIGHT_CORNER_SYMBOL;


        $this->paintContent = implode($result, PHP_EOL);
    }

    /**
     * @param string $content
     * @param int $horizontalPadding
     * @param int $verticalPadding
     *
     * @return BorderedBoxPaintVo
     */
    public static function withStringContent(
        string $content,
        int $horizontalPadding = 30,
        int $verticalPadding = 1
    ): BorderedBoxPaintVo {
        return new self($content, $horizontalPadding, $verticalPadding);
    }

    /**
     * @param string[] $rowList
     * @param int $horizontalPadding
     * @param int $verticalPadding
     *
     * @return BorderedBoxPaintVo
     */
    public static function withRowList(
        array $rowList,
        int $horizontalPadding = 30,
        int $verticalPadding = 1
    ): self {
        $content = implode($rowList, PHP_EOL);
        return new self($content, $horizontalPadding, $verticalPadding);
    }
}
