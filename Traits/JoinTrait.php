<?php

namespace nlib\Orm\Traits;

use nlib\Orm\Entity\Join;

trait JoinTrait {

    private $_Join;

    #region Getter

    public function Join() : Join {
        if(empty($this->_Join)) $this->setJoin(new Join);
        return $this->_Join;
    }
    
    #endregion

    #region Setter

    public function setJoin(Join $Join) : self { $this->_Join = $Join; return $this; }
    
    #endregion
}