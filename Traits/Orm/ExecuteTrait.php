<?php

namespace nlib\Orm\Traits\Orm;

use nlib\Orm\Classes\Connection;
use PDOStatement;

trait ExecuteTrait {

    use PrepareTrait;
    use BindTrait;

    protected $_dieexception = false;

    protected function execute(string $sql, array $binds = []) : ?PDOStatement {
        
        $req = null;

        try {

            $req = Connection::i($this->_i())->getConnection()->prepare($sql);
            $this->bind($req, $binds);
            $this->debug($sql, $binds, $req);
            $req->execute();
            
        } catch(\Exception $e) {
            $this->log([__CLASS__ . '::' . __FUNCTION__ => json_encode($message = $e->getMessage())]);
            if($this->getDieException()) die($message);
        }

        return $req;
    }

    #region Getter

    public function getDieException() : bool { return $this->_dieexception; }
    
    #region

    #region Setter

    public function setDieException(bool $die) : self { $this->_dieexception = $die; return $this; }

    #endregion
}