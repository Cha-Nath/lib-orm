<?php

namespace nlib\Orm\Classes;

use nlib\Orm\Interfaces\ExecuteInterface;
use nlib\Orm\Interfaces\ManagerInterface;
use nlib\Yaml\Interfaces\ParserTraitInterface;

use nlib\Path\Classes\Path;

use nlib\Yaml\Traits\ParserTrait;
use nlib\Orm\Traits\Orm\ExecuteTrait;
use nlib\Orm\Traits\Orm\QueryTrait;

class Manager implements ManagerInterface, ExecuteInterface, ParserTraitInterface {

    use ParserTrait;
    use ExecuteTrait;
    use QueryTrait;

    private $_table;
    private $_prefix;
    private $_entity;
    
    public function __construct() {
        
        $db = $this->Parser()->get(Path::i()->getConfig() . 'db');
        $this->setPrefix($db['prefix']);

        Connection::i()->init($db);
    }

    public function init(string $entity) : self {
        if(!empty($entity) && class_exists($entity)) :
            $exs = explode('\\', $entity);
            $this->setTable(strtolower(end($exs)))->setEntity($entity);
        endif;

        return $this;
    }

    public function findBy(array $parameters = []) : array {
        
        $entities = $binds = [];
        
        $binds = $this->prepareParameters($parameters);
        $sql = $this->select() . $this->from() . $this->where() . $this->sort();

        $req = $this->execute($sql, $binds);

        $entity = $this->getEntity();
        while($r = $req->fetch(\PDO::FETCH_ASSOC)) $entities[] = (new $entity)->hydrate($r);

        return $entities;
    }

    public function findOneBy(array $parameters = [], array $sortings = [], array $parts = []) {

        $sortings['LIMIT'] = 1;
        $entities = $this->findBy($parameters, $sortings, $parts);

        return !empty($entities) ? $entities[0] : null;
    }

    #region Getter
    
    public function getEntity() : string { return $this->_entity; }
    public function getPrefix() : string { return $this->_prefix; }
    public function getTable() : string { return $this->_prefix . $this->_table; }
    
    #endregion

    #region Setter
    
    public function setEntity(string $entity) : self { $this->_entity = $entity; return $this; }
    public function setPrefix(string $prefix) : self { $this->_prefix = $prefix; return $this; }
    public function setTable(string $table) : self { $this->_table = $table; return $this; }
    
    #endregion
}