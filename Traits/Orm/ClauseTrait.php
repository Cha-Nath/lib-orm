<?php

namespace nlib\Orm\Traits\Orm;

trait ClauseTrait {

    private $_clauses = [
        'parts' => ['select', 'from', 'where', 'update'],
        'sorts' => ['groupby', 'orderby', 'limit'],
    ];

    protected $_parts = [];
    protected $_sorts = [];

    protected function select() : string { return $this->getPart('select'); }
    
    protected function where() : string { return (($where = $this->getPart('where')) != $this->Query()->where()) ? $where : ''; }

    protected function _update() : string { return $this->getPart('update'); }
    
    protected function from() : string { return $this->getPart('from'); }

    protected function sort() : string {
        $sort = '';
        foreach($clauses = $this->getClauses('sorts') as $key)
            if(array_key_exists($key, $this->_sorts)) $sort .= $this->_sorts[$key];
        return $sort;
    }
    
    protected function getPart(string $key) : string {
        if(!array_key_exists($key, $this->_parts)) $this->_parts[$key] = $this->Query()->{$key}();
        return $this->_parts[$key];
    }
    
    protected function getClauses(string $clause) : array {
        return array_key_exists($clause, $this->_clauses) ? $this->_clauses[$clause] : [];
    }   

    protected function inClauses(string $clause, string $key) : bool {
        return in_array($key, $this->getClauses($clause));
    }

    // public function reset() : self { $this->_parts = []; $this->_sorts = []; return $this; }
}