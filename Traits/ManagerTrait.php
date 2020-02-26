<?php

namespace nlib\Orm\Traits;

use nlib\Orm\Classes\Manager;

trait ManagerTrait {

    private $_manager;

    #region Getter

    public function Manager(string $manager) : Manager {
        if(empty($this->_manager)) $this->setManager(new Manager);
        else $this->_manager->init($manager);
        return $this->_manager;
    }
    
    #endregion

    #region Setter

    public function setManager(Manager $manager) { $this->_manager = $manager; return $this; }
    
    #endregion
}