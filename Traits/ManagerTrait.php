<?php

namespace nlib\Orm\Traits;

use nlib\Orm\Classes\Manager;

trait ManagerTrait {

    private $_manager;

    #region Getter

    public function Manager(string $manager) : Manager {
        if(empty($this->_manager)) $this->setManager(new Manager);
        return $this->_manager->init($manager);
    }
    
    #endregion

    #region Setter

    public function setManager(Manager $manager) { $this->_manager = $manager; return $this; }
    
    #endregion
}