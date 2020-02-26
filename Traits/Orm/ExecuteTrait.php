<?php

namespace nlib\Orm\Traits\Orm;

use nlib\Orm\Classes\Connection;

trait ExecuteTrait {

    use PrepareTrait;
    use BindTrait;

    protected function execute(string $sql, array $binds = []) {
        
        $req = null;

        try {

            $req = Connection::i()->getConnection()->prepare($sql);
            $this->bind($req, $binds);
            $req->execute();
            
        } catch(\Exception $e) {
            die( 'Unable to execute request.' );
        }

        return $req;
    }
}