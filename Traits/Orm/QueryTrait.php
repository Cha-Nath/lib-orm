<?php

namespace nlib\Orm\Traits\Orm;

use nlib\Orm\Classes\QueryBuilder;
use nlib\Orm\Traits\QueryBuilderTrait;

trait QueryTrait {

    use QueryBuilderTrait;

    protected function Query() : QueryBuilder { return $this->QueryBuilder($this->getTable()); }

    protected function close(\PDOStatement &$req) : void {
        $req->closeCursor();
        $req = null;
    }
}