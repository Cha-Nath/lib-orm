<?php

namespace nlib\Orm\Traits\Orm;

use Nlib\ObjectList\Classes\ObjectList;
use nlib\Orm\Classes\Entity;
use nlib\Orm\Entity\EntityList;
use nlib\Orm\Entity\JoinList;
use nlib\Orm\Entity\ResultList;
use PDOStatement;

trait HandleTrait {

    protected function handleRowCount(PDOStatement &$req) : bool {

        $bool = (!empty($req->rowCount()) || $req->rowCount() == 0);

        $this->close($req);
        
        return $bool;
    }

    protected function handleSimpleDataObjects(PDOStatement &$req) : array {

        $entities = [];
        $entity = $this->getEntity();
        
        // $req->setFetchMode(\PDO::FETCH_ASSOC);
        // foreach($req as $r) $entities[] = (new $entity)->hydrate($r);
        while($r = $req->fetch(\PDO::FETCH_ASSOC)) $entities[] = (new $entity)->hydrate($r);

        $this->close($req);

        return $entities;
    }

    protected function handleMultipleDataObjects(PDOStatement &$req) : ResultList {

        $EntityList = new EntityList;
        $ResultList = new ResultList;
        
        $tmps = [];

        foreach($JoinList = $this->getJoins() as $Join) : $casts[$Join->getTable()] = $Join->getEntity(); $casts[$Join->getFTable()] = $Join->getFEntity(); endforeach;

        // var_dump($casts);
// var_dump($req->fetch(\PDO::FETCH_ASSOC));
        while($results = $req->fetch(\PDO::FETCH_ASSOC)) :
// var_dump($results);
            // foreach($results as $r) :
                $List = clone $EntityList;

                foreach($results as $key => $value) :
                    $explodes = explode('__', $key);
                    $table = str_replace($this->getPrefix(), '', $explodes[0]);
                    $tmps[$table][$explodes[1]] = $value;
                endforeach;

                foreach($tmps as $k => $tmp) :
                    $List->add((new $casts[$k])->hydrate($tmp), $casts[$k]);
                    
                    // $t[$casts[$k]] = (new $casts[$k])->hydrate($tmp);
                    // $t->add((new $casts[$k])->hydrate($tmp));
                endforeach;
// var_dump($List);
                // $ObjectList->add();
                // if(!$List->is_empty()) :
                    $ResultList->add($List);
                // endif;

                // $ventities[] = $tmps;
                // var_dump($tmps);
            // endforeach;
        endwhile;

        // foreach
        // var_dump($ResultList);

        return $ResultList;
    }

    protected function handleDataArray(PDOStatement &$req) : array {

        $results = $req->fetchAll(\PDO::FETCH_ASSOC);

        $this->close($req);

        return $results;
    }
}