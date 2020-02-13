<?php

namespace nlib\Orm\Traits;

use nlib\Orm\Classes\Entity;

trait EntityTrait {

    private $_entity;

    #region Getter

    public function Entity(string $entity = '') : Entity {
        if(!empty($entity) && class_exists($entity)) $this->setEntity(new $entity);
        elseif(empty($this->_entity)) $this->setEntity(new Entity);
        return $this->_entity;
    }
    
    #endregion

    #region Setter

    public function setEntity(Entity $entity) { $this->_entity = $entity; return $this; }
    
    #endregion
}