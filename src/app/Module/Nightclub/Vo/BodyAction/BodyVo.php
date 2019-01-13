<?php

namespace App\Module\Nightclub\Vo\BodyAction;

use SimpleDto\SimpleDto;

/**
 * Class BodyVo
 * @package App\Module\Nightclub\Vo\BodyAction
 */
class BodyVo extends SimpleDto
{
    public const BODY_CENTER_ROW_INDEX = 1;
    public const DEFAULT_STATE = [
        '     ',
        '  |  ',
        '     ',
    ];
    public const THROWS_BACK_STATE = [
        '     ',
        '  /  ',
        '     ',
    ];
    public const THROWS_FORWARD_STATE = [
        '     ',
        '  \  ',
        '     ',
    ];
    /** @var array */
    private $actionList;

    /**
     * @return BodyVo
     *
     * @throws \ReflectionException
     */
    public static function withSlowBodyShaking(): BodyVo
    {
        return new self([
            'actionList' => [
                self::THROWS_BACK_STATE,
                self::THROWS_FORWARD_STATE,
                self::DEFAULT_STATE,
            ],
        ]);
    }

    /**
     * @return BodyVo
     *
     * @throws \ReflectionException
     */
    public static function withActiveBodyShaking(): BodyVo
    {
        return new self([
            'actionList' => [
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