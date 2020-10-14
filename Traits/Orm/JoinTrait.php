<?php

namespace nlib\Orm\Traits\Orm;

use nlib\Orm\Entity\Join;
use nlib\Orm\Entity\JoinList;

trait JoinTrait {

    protected $_JoinList;

    public function join(string &$select, string &$from, string &$where) : void {

        $JoinList = $this->getJoins();
        $string = $from = '';
        $i = $JoinList->count();
        $prefix = $this->getPrefix();
        $Query = $this->Query();
        $tables = [];

        foreach($JoinList as $Join) :
            $table = $prefix . $Join->getTable();
            $ftable = $prefix . $Join->getFTable();

            if(!in_array($table, $tables)) $tables[] = $table;
            if(!in_array($ftable, $tables)) $tables[] = $ftable;

            $where .= $table . '.' . $Join->getKey() . '=' . $ftable . '.' . $Join->getFKey();

            if($i > 1) : $where .= ' AND '; endif;
            --$i;
        endforeach;

        $from = implode(', ', $tables);
        $in = implode('", "', $tables);
        $in = '"' . $in . '"';
        // var_dump($in);die;
        $sql = $Query
            ->reset()
            ->select('CONCAT(table_name, ".", column_name, " AS ", table_name, "__", column_name) field')
            ->from('information_schema.columns')
            ->where('table_name IN(' . $in  . ')')
            ->end();

        $req = $this->execute($sql, []);
        $results = $this->handleDataArray($req);
        $select = '';
// var_dump($results);die;
        $i = count($results);
        foreach($results as $values) :
            // var_dump($values);
            // if(!strpos($select, $values['field'])) $select .= $values['field'];

            $select .= $values['field'];
            if($i > 1) $select .= ', ';
            --$i;
        endforeach;

        // var_dump($select);
        // return $from;
        // $this->setDebug(true);



        // $sql = $this->Query()
        //     ->select($string)
        //     ->from($from)
        //     ->end();

        // $req = $this->execute($sql);
        // $results = $this->handleMultipleDataObjects($req, $JoinList);



        // var_dump($results);
        
        // SELECT CONCAT(table_name, ".", column_name, " AS ", CHAR(256), table_name, ".", column_name, CHAR(256)) field_names FROM information_schema.columns WHERE table_name IN(
        //     "wpcf_request",
        //     "wpcf_step1"
        // )
    }

    public function getJoins() : ?JoinList { return $this->_JoinList; }

    public function setJoins(JoinList $JoinList) : self { $this->_JoinList = $JoinList; return $this; }
}