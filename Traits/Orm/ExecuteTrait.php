<?php

namespace nlib\Orm\Traits\Orm;

use nlib\Orm\Classes\Connection;
use PDOStatement;

trait ExecuteTrait {

    use PrepareTrait;
    use BindTrait;

    protected function execute(string $sql, array $binds = []) : ?PDOStatement {
        
        $req = null;

        try {

            $req = Connection::i()->getConnection()->prepare($sql);
            $this->bind($req, $binds);
            $this->debug($sql, $binds, $req);
            $req->execute();
            
        } catch(\Exception $e) {
            die( 'Unable to execute request.' );
        }

        return $req;
    }
}