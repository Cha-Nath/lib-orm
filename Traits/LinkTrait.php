<?php

namespace nlib\Orm\Traits;

use nlib\Orm\Entity\Link;

trait LinkTrait {

    private $_Link;

    #region Getter

    public function Link() : Link {
        if(empty($this->_Link)) $this->setLink(new Link);
        return $this->_Link;
    }
    
    #endregion

    #region Setter

    public function setLink(Link $Link) : self { $this->_Link = $Link; return $this; }
    
    #endregion
}