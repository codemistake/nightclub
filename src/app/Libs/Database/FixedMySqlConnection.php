<?php

namespace App\Libs\Database;

use Illuminate\Database\MySqlConnection;
use PDO;

/**
 * @see https://github.com/laravel/framework/issues/23850
 */
class FixedMySqlConnection extends MySqlConnection
{
    public function bindValues($statement, $bindings)
    {
        foreach ($bindings as $key => $value) {
            $statement->bindValue(
                is_string($key) ? $key : $key + 1, $value,
                is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR
            );
        }
    }
}