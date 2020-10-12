<?php

namespace nlib\Orm\Traits\Orm;

use nlib\Orm\Entity\JoinList;

trait JoinTrait {

    protected $_JoinList;

    public function t(JoinList $JoinList, string $prefix) {

        $in = '';
        $i = $JoinList->count();
        // $prefix;

        foreach($JoinList as $Join) :
            $in .= $prefix . $Join->getTable() . ', ' . $prefix . $Join->getFTable();
            if($i > 1) $in .= ', ';
            --$i;
        endforeach;
        
        // SELECT CONCAT(table_name, ".", column_name, " AS ", CHAR(256), table_name, ".", column_name, CHAR(256)) field_names FROM information_schema.columns WHERE table_name IN(
        //     "wpcf_request",
        //     "wpcf_step1"
        // )
    }

    public function getJoins() : JoinList { return $this->_JoinList; }

    public function seJoins(JoinList $JoinList) : self { $this->_JoinList = $JoinList; return $this; }
}