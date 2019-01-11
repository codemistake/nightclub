<?php

namespace App\Core\Job;

/**
 * Class QueueNameEnum
 * @package App\Core\Job
 */
interface QueueNameEnum
{
    // Для писем
    public const EMAILS = 'emails';

    // Для обращения к VIMB в несколько потоков (для каждого метода кол-во потоков может быть разным)
    public const VIMB_API_DEFAULT = 'vimb-api-default';

    public const VIMB_API_GET_MEDIAPLANS_TOP = 'vimb-api-get-mediaplans-top';
    public const VIMB_API_GET_MEDIAPLANS_HIGH = 'vimb-api-get-mediaplans-high';
    public const VIMB_API_GET_MEDIAPLANS_NORMAL = 'vimb-api-get-mediaplans-normal';
    public const VIMB_API_GET_MEDIAPLANS_LOW = 'vimb-api-get-mediaplans-low';
    public const VIMB_API_GET_MEDIAPLANS_BACKGROUND = 'vimb-api-get-mediaplans-background';

    public const VIMB_API_GET_BLOCKS_TOP = 'vimb-api-get-blocks-top';
    public const VIMB_API_GET_BLOCKS_HIGH = 'vimb-api-get-blocks-high';
    public const VIMB_API_GET_BLOCKS_NORMAL = 'vimb-api-get-blocks-normal';
    public const VIMB_API_GET_BLOCKS_LOW = 'vimb-api-get-blocks-low';
    public const VIMB_API_GET_BLOCKS_BACKGROUND = 'vimb-api-get-blocks-background';

    public const VIMB_API_GET_SPOTS_TOP = 'vimb-api-get-spots-top';
    public const VIMB_API_GET_SPOTS_HIGH = 'vimb-api-get-spots-high';
    public const VIMB_API_GET_SPOTS_NORMAL = 'vimb-api-get-spots-normal';
    public const VIMB_API_GET_SPOTS_LOW = 'vimb-api-get-spots-low';
    public const VIMB_API_GET_SPOTS_BACKGROUND = 'vimb-api-get-spots-background';

    public const VIMB_API_ADD_SPOT = 'vimb-api-add-spot';
    public const VIMB_API_DELETE_SPOT = 'vimb-api-delete-spot';
    public const VIMB_API_REPLACE_FILMS = 'vimb-api-replace-films';

    // Для парсинга данных из VIMB
    public const VIMB_PARSING = 'vimb-parsing';

    // Очереди для различных модулей
    public const PLAN_FILE_PARSING = 'plan-file-parsing';
    public const PALOMARS_AFFINITY_PARSING = 'palomars-affinity-parsing';
    public const PALOMARS_AFFINITY_FORECAST = 'palomars-affinity-forecast';
    public const BROADCAST_GRID_STAT_UPDATE = 'broadcast-grid-stat-update';
}
