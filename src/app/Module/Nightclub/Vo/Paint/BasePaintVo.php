<?php

namespace App\Module\Nightclub\Vo\Paint;

/**
 * Class BasePaintVo
 * @package App\Module\Nightclub\Vo\Paint
 */
class BasePaintVo
{
    /** @var string */
    protected $paintContent;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->paintContent;
    }

    /**
     * @param array $paintRowList
     * @param int $paddingWidth
     * @param bool $needAlignCenter
     *
     * @return array
     */
    protected function padRowListToMaxRowWidth(
        array $paintRowList,
        int $paddingWidth = 0,
        bool $needAlignCenter = true
    ): array {
        $maxWidth = 0;
        $correctRowList = [];
        foreach ($paintRowList as $rowValue) {
            $rowLength = \mb_strlen($rowValue);
            if ($rowLength > $maxWidth) {
                $maxWidth = $rowLength;
            }
        }

        foreach ($paintRowList as $key => $rowValue) {
            $correctRowList[$key] = $this->padStringToFixedWidth(
                $rowValue,
                $maxWidth + $paddingWidth,
                ' ',
                $needAlignCenter
            );
        }

        return $correctRowList;
    }

    /**
     * @param string $inputString
     * @param int $newLength
     * @param string $padString
     * @param bool $needAlignCenter
     *
     * @return string
     */
    protected function padStringToFixedWidth(
        string $inputString,
        int $newLength,
        string $padString = ' ',
        bool $needAlignCenter = true
    ): string {
        $str_len = \mb_strlen($inputString);
        $pad_str_len = \mb_strlen($padString);

        if ($str_len > $newLength) {
            $inputString = mb_substr($inputString, $newLength);
            $str_len = \mb_strlen($inputString);
        }
        $length = ($newLength - $str_len) / 2;
        $repeat = ceil($length / ($pad_str_len > 0 ? $pad_str_len : 1));

        if ($needAlignCenter) {
            $result = \mb_substr(str_repeat($padString, $repeat), 0, floor($length));
            $result .= $inputString;
            $result .= \mb_substr(str_repeat($padString, $repeat), 0, ceil($length));
            return $result;
        }


        $result = $inputString;
        $result .= str_repeat($padString, $repeat);
        return $result;
    }
}
