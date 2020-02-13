<?php

namespace nlib\Orm\Interfaces;

interface ConnectionInterface {

    /**
     *
     * @return Connection
     */
    public static function i();

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