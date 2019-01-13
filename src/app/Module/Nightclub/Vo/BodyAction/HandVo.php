<?php

namespace App\Module\Nightclub\Vo\BodyAction;

use SimpleDto\SimpleDto;

/**
 * Class HandVo
 * @package App\Module\Nightclub\Vo\BodyAction
 */
class HandVo extends SimpleDto
{
    private const LEFT_HAND_DEFAULT_STATE = [
        '     ',
        '/    ',
        '     ',
    ];
    private const LEFT_HAND_NEAR_BELT_STATE = [
        '     ',
        '\    ',
        '     ',
    ];
    private const LEFT_HAND_ON_TOP_STATE = [
        '\    ',
        '     ',
        '     ',
    ];
    private const RIGHT_HAND_DEFAULT_STATE = [
        '     ',
        '    \\',
        '     ',
    ];
    private const RIGHT_HAND_NEAR_BELT_STATE = [
        '     ',
        '    /',
        '     ',
    ];
    private const RIGHT_HAND_ON_TOP_STATE = [
        '    /',
        '     ',
        '     ',
    ];

    /** @var array */
    private $leftHandActionList;
    /** @var array */
    private $rightHandActionList;

    /**
     * @return HandVo
     *
     * @throws \ReflectionException
     */
    public static function withBeltOriented(): HandVo
    {
        return new self([
            'leftHandActionList' => [
                self::LEFT_HAND_NEAR_BELT_STATE,
                self::LEFT_HAND_NEAR_BELT_STATE,
                self::LEFT_HAND_DEFAULT_STATE,
            ],
            'rightHandActionList' => [
                self::RIGHT_HAND_DEFAULT_STATE,
                self::RIGHT_HAND_NEAR_BELT_STATE,
                self::RIGHT_HAND_DEFAULT_STATE,
            ],
        ]);
    }

    /**
     * @return HandVo
     *
     * @throws \ReflectionException
     */
    public static function withSpinStyle(): HandVo
    {
        return new self([
            'leftHandActionList' => [
                self::LEFT_HAND_DEFAULT_STATE,
                self::LEFT_HAND_NEAR_BELT_STATE,
                self::LEFT_HAND_ON_TOP_STATE,
            ],
            'rightHandActionList' => [
                self::RIGHT_HAND_NEAR_BELT_STATE,
                self::RIGHT_HAND_ON_TOP_STATE,
                self::LEFT_HAND_DEFAULT_STATE,
            ],
        ]);
    }

    /**
     * @return HandVo
     *
     * @throws \ReflectionException
     */
    public static function withSlowStyle(): HandVo
    {
        return new self([
            'leftHandActionList' => [
                self::LEFT_HAND_DEFAULT_STATE,
                self::LEFT_HAND_NEAR_BELT_STATE,
                self::LEFT_HAND_NEAR_BELT_STATE,
                self::LEFT_HAND_NEAR_BELT_STATE,
                self::LEFT_HAND_ON_TOP_STATE,
            ],
            'rightHandActionList' => [
                self::RIGHT_HAND_NEAR_BELT_STATE,
                self::RIGHT_HAND_NEAR_BELT_STATE,
                self::RIGHT_HAND_NEAR_BELT_STATE,
                self::RIGHT_HAND_ON_TOP_STATE,
                self::RIGHT_HAND_ON_TOP_STATE,
            ],
        ]);
    }

    /**
     * @return array
     */
    public function getLeftHandActionList(): array
    {
        return $this->leftHandActionList;
    }

    /**
     * @return array
     */
    public function getRightHandActionList(): array
    {
        return $this->rightHandActionList;
    }
}