<?php

namespace nlib\Orm\Entity;

use Nlib\ObjectList\Classes\ObjectList;

class Link extends ObjectList {

    protected $_entity;
    protected $_table;
    protected $_id;
    protected $_ftable;
    protected $_fid;

    #region Getter

    public function getentity() : string { return $this->_entity; }
    public function gettable() : string { return $this->_table; }
    public function getid() : string { return $this->_id; }
    public function getftable() : string { return $this->_ftable; }
    public function getfid() : string { return $this->_fid; }

    #endregion

    #region Setter

    public function setentity($entity) : self { $this->_entity = $entity; return $this; }
    public function settable($table) : self { $this->_table = $table; return $this; }
    public function setid($id) : self { $this->_id = $id; return $this; }
    public function setftable($ftable) : self { $this->_ftable = $ftable; return $this; }
    public function setfid($fid) : self { $this->_fid = $fid; return $this; }

    #endregion
}