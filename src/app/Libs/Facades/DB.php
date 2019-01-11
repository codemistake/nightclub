<?php

namespace App\Libs\Facades;

/**
 * @method static \Illuminate\Database\Connection connection($name = null)
 * @method static beginTransaction()
 * @method static commit()
 * @method static rollBack()
 * @method static raw($value)
 * @method static \Illuminate\Database\Query\Builder query()
 * @method static \Illuminate\Database\Query\Builder table($table)
 * @method static select($query, $bindings = [], $useReadPdo = true)
 * @method static cursor($query, $bindings = [], $useReadPdo = true)
 * @method static enableQueryLog()
 * @method static logQuery($query, $bindings, $time = null)
 * @method static getQueryLog()
 * @method static flushQueryLog()
 */
class DB extends \Illuminate\Support\Facades\DB
{

}