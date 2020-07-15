<?php

namespace nlib\Orm\Traits;

use nlib\Orm\Classes\Manager;

trait ManagerTrait {

    private $_manager;

    #region Getter

    public function Manager(string $manager) : Manager {
        $instance = (method_exists($this, $method = '_i')) ? $this->{$method}() : 'i';
        if(empty($this->_manager)) $this->setManager(new Manager($instance));
        return $this->_manager->setInstance($instance)->init($manager);
    }
    
    #endregion

    #region Setter

    public function setManager(Manager $manager) { $this->_manager = $manager; return $this; }
    
    #endregion
}