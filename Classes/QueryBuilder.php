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
        $this->_query .= ' FROM ' . $this->getTable($table) . ' ';
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

    public function update(string $table = '', string $update = '') : self {
        $this->_query .= 'UPDATE ' . $this->getTable($table) . ' SET ' . $update . ' ';
        return $this;
    }

    public function insert(string $table = '', string $key = '{key}', string $value = '{value}') : self {
        $this->_query .= 'INSERT' . $this->into($table, $key, $value);
        return $this;
    }

    public function replace(string $table = '', string $key = '{key}', string $value = '{value}') : self {
        $this->_query .= 'REPLACE' . $this->into($table, $key, $value);
        return $this;
    }

    public function end() : self {
        $this->_query .= ';';
        return $this;
    }

    public function into(string $table = '', string $key = '', string $value = '') : string {
        return ' INTO ' . $this->getTable($table) . ' (' . $key . ') VALUES (' . $value . ') ';
    }

    public function reset() : self { $this->_query = ''; return $this; }
    

    #region Getter
    
    public function getTable(string $table = '') { return (!empty($table) ? $table : $this->_table); }

    public function innerJoin(string $table, string $ftable, string $key, string $fkey) {
        $this->_query .= ' ' . $table .  ' INNER JOIN ' . $ftable . ' ON ' . $table . '.' . $key . '=' . $ftable . '.' . $fkey;
        return $this;
    }

    #endregion
}