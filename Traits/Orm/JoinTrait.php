<?php

namespace nlib\Orm\Traits\Orm;

use nlib\Orm\Entity\JoinList;

trait JoinTrait {

    protected $_JoinList;

    public function join() {

        $JoinList = $this->getJoins();
        $string = '';
        $i = $JoinList->count();
        $prefix = $this->getPrefix();

        foreach($JoinList as $Join) :
            $string .= $prefix . $Join->getTable() . ', ' . $prefix . $Join->getFTable();
            if($i > 1) $string .= ', ';
            --$i;
        endforeach;

        $sql = $this->Query()
            ->select('CONCAT(table_name, ".", column_name, " AS ", CHAR(256), table_name, ".", column_name, CHAR(256)) field_names')
            ->from('information_schema.columns')
            ->where('table_name IN(' . $string . ')')
            ->end();

        $req = $this->execute($sql, []);
        $results = $this->handleDataArray($req);
        $string = $sql = '';

        $i = count($results);
        foreach($results as $value) :
            $string .= $value;
            if($i > 1) $string = ', ';
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