<?php

namespace nlib\Orm\Classes;

class QueryBuilder {

    private $_query;
    private $_table;

    public function __construct(string $table) {
        $this->_table = $table;
        $this->_query = '';
    }

    public function __toString() {
        return $this->_query;
    }

    public function select(string $select = '*', bool $calc = false) : self {
        $this->_query .= 'SELECT ' . ($calc ? ' sql_calc_found_rows ' : ' ') . $select . ' ';
        return $this;
    }

    public function from(string $table = '') : self {
        $this->_query = ' FROM ' . (!empty($table) ? $table : $this->_table . ' ');
        return $this;
    }

    public function where(string $where = '') : self {
        $this->_query .= ' WHERE ' . $where . ' ';
        return $this;
    }

    public function limit(int $limit) {
        if($limit > 0) $this->_query .= ' LIMIT ' . $limit;
        return $this->_query;
    }

    public function groupBy(string $groupby) {
        $this->_query .= ' GROUP BY ' . $groupby;
        return $this;
    }

    public function orderBy(string $orderby) : self {
        $this->_query .= ' ORDER BY ' . str_replace(['|', ';'], [' ', ', '], $orderby);
        return $this;
    }

    public function end() : self {
        $this->_query .= ';';
        return $this;
    }
}