<?php

namespace nlib\Orm\Interfaces;

use nlib\Orm\Entity\LinkList;

interface LinkListTraitInterface {

    /**
     *
     * @return LinkList
     */
    public function LinkList() : LinkList;
    
    /**
     *
     * @param LinkList $LinkList
     * @return self
     */
    public function setLinkList(LinkList $LinkList);
}