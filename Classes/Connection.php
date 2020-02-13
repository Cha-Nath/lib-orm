<?php

namespace nlib\Orm\Classes;

use nlib\Orm\Interfaces\ConnectionInterface;

class Connection implements ConnectionInterface {

    private static $_i = null;

    private $_connection = null;
    private $_name;
    private $_user;
    private $_pwd;
    private $_host;

    private function __construct() {}

    public static function i() { 
        if(empty(self::$_i)) self::$_i = new Connection;

        return self::$_i;
    }

    public function init(array $parameters) {

        foreach($parameters as $key => $value)
            if(property_exists($this, $property = '_' . $key)) $this->{$property} = $value;

            try {
                ($connection = new \PDO(
                    'mysql:host=' . $this->_host . ';dbname=' . $this->_name,
                    $this->_user,
                    $this->_pwd,
                    [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']
                ))->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_WARNING);
                    
                $this->setConnection($connection);

        } catch (\Exception $e){
            die( 'PDO connexion error n° ' . $e->getCode() . ': ' . $e->getMessage() );
        }
    }

    public function setConnection($connection) { $this->_connection = $connection; return $this; }

    public function getConnection() { return $this->_connection; }
}