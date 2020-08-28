<?php

namespace nlib\Orm\Interfaces;

use PDO;
use nlib\Orm\Classes\Connection;

interface ConnectionInterface {

    /**
     *
     * @param string $instance
     * @return Connection
     */
    public static function i(string $instance = 'i') : Connection;

    /**
     *
     * @param null|PDO $connection
     * @return this
     */
    public function setConnection(?PDO $connection);

    /**
     *
     * @return null|PDO
     */
    public function getConnection() : ?PDO;
}