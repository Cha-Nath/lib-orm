<?php

namespace nlib\Orm\Classes;

use nlib\Orm\Interfaces\DebugTraitInterface;
use nlib\Orm\Interfaces\PrepareTraitInterface;
use nlib\Orm\Interfaces\ManagerInterface;
use nlib\Yaml\Interfaces\ParserTraitInterface;
use nlib\Tool\Interfaces\StringTraitInterface;

use nlib\Path\Classes\Path;

use nlib\Yaml\Traits\ParserTrait;
use nlib\Orm\Traits\Orm\DebugTrait;
use nlib\Orm\Traits\Orm\ExecuteTrait;
use nlib\Orm\Traits\Orm\HandleTrait;
use nlib\Orm\Traits\Orm\QueryTrait;

class Manager implements ManagerInterface, ParserTraitInterface, PrepareTraitInterface, StringTraitInterface, DebugTraitInterface {

    use ParserTrait;
    use ExecuteTrait;
    use QueryTrait;
    use HandleTrait;
    use DebugTrait;

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
        $sql = $this->_select() . $this->_from() . $this->_where() . $this->_sort() . $this->Query()->end();

        $req = $this->execute($sql, $binds);

        return $this->handleSimpleDataObjects($req);
    }

    public function findOneBy(array $parameters = []) {

        $entities = $this->prepareSorts(['limit' => 1])->findBy($parameters);

        return !empty($entities) ? $entities[0] : null;
    }

    public function update(array $values, array $parameters = []) : bool {

        $vbinds = $this->prepareParameters($values, 'update', ', ', 'set_');
        $pbinds = $this->prepareParameters($parameters);

        $binds = array_merge($vbinds, $pbinds);
        
        $sql = $this->_update() . $this->_where() . $this->Query()->end();
        $req = $this->execute($sql, $binds);

        return $this->handleRowCount($req);
    }

    public function insert(array $values, array $parameters = []) : bool {

        $vbinds = $this->prepareParameters($values, 'insert', ', ', 'into_', true);
        $pbinds = $this->prepareParameters($parameters);

        $binds = array_merge($vbinds, $pbinds);
        
        $sql = $this->_insert() . $this->_where() . $this->Query()->end();
        
        $req = $this->execute($sql, $binds);

        return $this->handleRowCount($req);
    }

    public function replace(array $values, array $parameters = []) : bool {

        $vbinds = $this->prepareParameters($values, 'replace', ', ', 'replace_', true);
        $pbinds = $this->prepareParameters($parameters);

        $binds = array_merge($vbinds, $pbinds);
        
        $sql = $this->_replace() . $this->_where() . $this->Query()->end();
        
        $req = $this->execute($sql, $binds);

        return $this->handleRowCount($req);
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