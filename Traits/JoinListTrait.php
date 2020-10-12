<?php

namespace nlib\Orm\Traits;

use nlib\Orm\Entity\JoinList;

trait JoinListTrait {

    private $_JoinList;

    #region Getter

    public function JoinList() : JoinList {
        if(empty($this->_JoinList)) $this->setJoinList(new JoinList);
        return $this->_JoinList;
    }
    
    #endregion

    #region Setter

    public function setJoinList(JoinList $JoinList) : self { $this->_JoinList = $JoinList; return $this; }
    
    #endregion
}