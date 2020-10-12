<?php

namespace nlib\Orm\Traits;

use nlib\Orm\Entity\LinkList;

trait LinkListTrait {

    private $_LinkList;

    #region Getter

    public function LinkList() : LinkList {
        if(empty($this->_LinkList)) $this->setLinkList(new LinkList);
        return $this->_LinkList;
    }
    
    #endregion

    #region Setter

    public function setLinkList(LinkList $LinkList) : self { $this->_LinkList = $LinkList; return $this; }
    
    #endregion
}