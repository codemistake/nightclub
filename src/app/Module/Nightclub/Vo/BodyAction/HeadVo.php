<?php

namespace App\Module\Nightclub\Vo\BodyAction;

use SimpleDto\SimpleDto;

/**
 * Class HeadVo
 * @package App\Module\Nightclub\Vo\BodyAction
 */
class HeadVo extends SimpleDto
{
    public const HEAD_ROW_INDEX = 0;
    private const DEFAULT_STATE = [
        '  0  ',
        '     ',
        '     ',
    ];
    private const THROWS_BACK_STATE = [
        '   o ',
        '     ',
        '     ',
    ];
    private const THROWS_FORWARD_STATE = [
        ' o   ',
        '     ',
        '     ',
    ];
    /** @var array */
    private $actionList;

    /**
     * @return HeadVo
     *
     * @throws \ReflectionException
     */
    public static function withPassiveStyle(): HeadVo
    {
        return new self([
            'actionList' => [
                self::DEFAULT_STATE,
                self::DEFAULT_STATE,
                self::DEFAULT_STATE,
                self::DEFAULT_STATE,
                self::DEFAULT_STATE,
                self::DEFAULT_STATE,
                self::DEFAULT_STATE,
                self::THROWS_BACK_STATE,
                self::THROWS_FORWARD_STATE,
            ],
        ]);
    }

    /**
     * @return HeadVo
     *
     * @throws \ReflectionException
     */
    public static function withActiveShaking(): HeadVo
    {
        return new self([
            'actionList' => [
                self::DEFAULT_STATE,
                self::THROWS_BACK_STATE,
                self::THROWS_FORWARD_STATE,
            ],
        ]);
    }

    /**
     * @return HeadVo
     *
     * @throws \ReflectionException
     */
    public static function withRareShaking(): HeadVo
    {
        return new self([
            'actionList' => [
                self::DEFAULT_STATE,
                self::DEFAULT_STATE,
                self::DEFAULT_STATE,
                self::THROWS_BACK_STATE,
                self::THROWS_FORWARD_STATE,
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
