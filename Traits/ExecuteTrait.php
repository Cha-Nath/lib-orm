<?php

namespace nlib\Orm\Traits;

use nlib\Orm\Classes\Connection;

trait ExecuteTrait {

    use ValueTrait;

    protected function execute(string $sql, array $parameters = []) {
        
        $req = null;
        $values = [];

        try {

            $this->prepare($sql, $values, $parameters);

            $req = Connection::i()->getConnection()->prepare($sql);
                
            $this->bind($req, $values);

            $req->execute();
            
        } catch(\Exception $e) {
            die( 'Unable to execute request.' );
        }

        return $req;
    }
}