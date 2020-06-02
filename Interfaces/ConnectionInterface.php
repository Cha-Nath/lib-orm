<?php

namespace nlib\Orm\Interfaces;

interface ConnectionInterface {

    /**
     *
     * @param string $instance
     * @return Connection
     */
    public static function i(string $instance = 'i');

    /**
     *
     * @param [type] $connection
     * @return this
     */
    public function setConnection($connection);

    /**
     *
     * @return PDO
     */
    public function getConnection();
}