<?php

namespace App\Module\Nightclub\Vo\BodyAction;

use SimpleDto\SimpleDto;

class LegVo extends SimpleDto
{
    private const DEFAULT_STATE = [
        '     ',
        '     ',
        ' / \ ',
    ];
    private const THROWS_BACK_STATE = [
        '     ',
        '     ',
        '  \\\ ',
    ];
    private const THROWS_FORWARD_STATE = [
        '     ',
        '     ',
        ' //  ',
    ];
    /** @var array */
    private $actionList;

    /**
     * @return LegVo
     *
     * @throws \ReflectionException
     */
    public static function withPassiveStyle(): LegVo
    {
        return new self([
            'actionList' => [
                self::DEFAULT_STATE,
                self::THROWS_BACK_STATE,
                self::DEFAULT_STATE,
                self::DEFAULT_STATE,
                self::THROWS_FORWARD_STATE,
                self::DEFAULT_STATE,
            ],
        ]);
    }

    /**
     * @return array
     */
    public function getActionList(): array
    {
        return $this->actionList;
    }
}