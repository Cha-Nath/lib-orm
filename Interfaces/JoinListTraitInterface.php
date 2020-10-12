<?php

namespace nlib\Orm\Interfaces;

use nlib\Orm\Entity\JoinList;

interface JoinListTraitInterface {

    /**
     *
     * @return JoinList
     */
    public function JoinList() : JoinList;
    
    /**
     *
     * @param JoinList $JoinList
     * @return self
     */
    public function setJoinList(JoinList $JoinList);
}