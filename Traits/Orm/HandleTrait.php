<?php

namespace nlib\Orm\Traits\Orm;

use PDOStatement;

trait HandleTrait {

    protected function handleRowCount(PDOStatement &$req) : bool {

        $bool = (!empty($req->rowCount()) || $req->rowCount() == 0);

        $this->close($req);
        
        return $bool;
    }

    protected function handleSimpleDataObjects(PDOStatement &$req) : array {

        $entity = $this->getEntity();
        while($r = $req->fetch(\PDO::FETCH_ASSOC)) $entities[] = (new $entity)->hydrate($r);

        $this->close($req);

        return $entities;
    }
}