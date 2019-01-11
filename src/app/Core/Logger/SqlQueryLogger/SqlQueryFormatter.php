<?php

namespace App\Core\Logger\SqlQueryLogger;

/**
 * Class SqlQueryFormatter
 * @package App\Core\Logger\SqlQueryLogger
 */
class SqlQueryFormatter
{
    /** @var string */
    private $query;
    /** @var array|null */
    private $bindings;

    /**
     * SqlQueryFormatter constructor.
     * @param string $query
     * @param array|null $bindings
     */
    public function __construct(string $query, ?array $bindings)
    {
        $this->query = $query;
        $this->bindings = $bindings;
    }

    /**
     * @return string
     */
    public function toRawSql(): string
    {
        $query = $this->query;
        $bindings = $this->bindings;

        if ($bindings !== null) {
            // Format binding data for sql insertion
            foreach ($bindings as $i => $binding) {
                if ($binding instanceof \DateTime) {
                    $bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
                } else if (is_string($binding)) {
                    $bindings[$i] = "'$binding'";
                } else if (is_null($binding)) {
                    $bindings[$i] = 'null';
                } else if (is_bool($binding)) {
                    $bindings[$i] = $binding ? '1' : '0';
                }
            }
        }

        // Insert bindings into query
        $query = str_replace(array('%', '?'), array('%%', '%s'), $query);

        // Remove new lines
        $query = str_replace(array("\n", "\r", "\t"), '', $query);

        // Remove extra spaces
        $query = preg_replace('/\s+/', ' ', $query);

        if ($bindings !== null) {
            foreach ($bindings as $key => $value) {
                $query = str_replace(':' . $key, $value, $query);
            }
        }

        return vsprintf($query, $bindings);
    }
}
