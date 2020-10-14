<?php

namespace nlib\Orm\Classes;

use nlib\Instance\Traits\InstanceTrait;
use nlib\Orm\Entity\ResultList;
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
use nlib\Orm\Traits\Orm\JoinTrait;
use nlib\Orm\Traits\Orm\QueryTrait;

class Manager implements ParserTraitInterface, PrepareTraitInterface, StringTraitInterface, DebugTraitInterface {

    use ParserTrait;
    use ExecuteTrait;
    use QueryTrait;
    use HandleTrait;
    use DebugTrait;
    use InstanceTrait;
    use JoinTrait;

    private $_table;
    private $_prefix;
    private $_entity;
    
    public function __construct(string $instance = 'i') {
        
        $db = [];
        $this->setInstance($instance);
        $config = Path::i($this->_i())->getConfig() . 'db';

        if(file_exists($config . '.yaml')) :
            $db = $this->Parser()->get($config);
            $this->setPrefix($db['prefix']);
        endif;

        Connection::i($this->_i())->init($db);
    }

    public function init(string $entity) : self {
        if(!empty($entity) && class_exists($entity)) :
            $exs = explode('\\', $entity);
            $this->setTable(strtolower(end($exs)))->setEntity($entity);
        endif;

        return $this;
    }

    public function findBy(array $parameters = []) {
        
        $binds = [];
        $Query = $this->Query();        
        $method = 'handleSimpleDataObjects';
        $binds = $this->prepareParameters($parameters);
        $w = $this->_where();
        // var_dump();die;
        if(!empty($this->getJoins())) :
            $select = $from = $where = '';
            $method = 'handleMultipleDataObjects';

            $this->join($select, $from, $where);

            // $w = $this->_where();
            // var_dump($where);
            // var_dump($this->log([$w]));die;

            $sql = $Query->select($select)->from($from) . $w;
            // $sql .= $Query->where('cpuc');
            // var_dump($this->log([$Query->where('cpuc')]));die;


            if(!empty($w)) $sql .= ' AND ' . $where;
            else $sql .= $Query->where($where);

            // var_dump($this->log([$sql]));die;
        else : $sql = $this->_select() . $this->_from() . $this->_where(); endif;
        
        $sql .= $this->_sort() . $this->Query()->end();

        // var_dump($this->log([$sql]));die;

        $req = $this->execute($sql, $binds);

        return $this->{$method}($req);
    }

    public function findOneBy(array $parameters = []) {

        $result = null;
        $entities = $this->prepareSorts(['limit' => 1])->findBy($parameters);

        if($entities instanceof ResultList) : $Results = $entities->get(); return reset($Results);
        elseif(!empty($entities)) : $result = $entities[0]; endif;

        return $result;
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

    public function run(string $file) : bool {

        $bool = false;

        if(file_exists($file)) :
            if(!empty($sql = file_get_contents($file))) :

                $req = $this->execute($sql, []);
                $this->close($req);

                $bool = true;

            endif;
        endif;

        return $bool;
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