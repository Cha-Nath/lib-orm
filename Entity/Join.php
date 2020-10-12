<?php

namespace nlib\Orm\Entity;

use Nlib\ObjectList\Classes\ObjectList;

class Join extends ObjectList {

    protected $_entity;
    protected $_table;
    protected $_key;
    protected $_fentity;
    protected $_ftable;
    protected $_fkey;

    #region Getter

    public function getEntity() : string { return $this->_entity; }
    public function getTable() : string { return $this->_table; }
    public function getKey() : string { return $this->_key; }
    public function getFEntity() : string { return $this->_fentity; }
    public function getFTable() : string { return $this->_ftable; }
    public function getFKey() : string { return $this->_fkey; }

    #endregion

    #region Setter

    public function setEntity($entity) : self { $this->_entity = $entity; return $this; }
    public function setTable($table) : self { $this->_table = $table; return $this; }
    public function setKey($key) : self { $this->_key = $key; return $this; }
    public function setFEntity($fentity) : self { return $this->_fentity = $fentity; return $this; }
    public function setFTable($ftable) : self { $this->_ftable = $ftable; return $this; }
    public function setFKey($fkey) : self { $this->_fkey = $fkey; return $this; }

    #endregion
}