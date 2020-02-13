<?php

namespace nlib\Orm\Traits;

use nlib\Tool\Traits\StringTrait;
use PDO;

trait ValueTrait {

    use StringTrait;

    protected function bind(&$req, array $parameters = []) {

        if(!empty($parameters))
            foreach ($parameters as $key => $param)
                $req->bindValue($key, $param[0], $param[1]);

    }

    protected function getPDOType($value) : int {
        $return = PDO::PARAM_STR;
        if(is_int($value)) $return = PDO::PARAM_INT;
        return $return;
    } 

    protected function prepare(string &$sql, array &$values, array $parameters) {

        if(!empty($parameters)) :
            $i = 0;
            $limit = '';
            $count = count($parameters);
            $sql .= ' WHERE ';
            foreach($parameters as $key => $value) :
                
                if($key === 'LIMIT') :
                    $limit = ' LIMIT ' . $value;
                    continue;
                endif;

                $slug = ':' . $this->str_slug($key);
                $sql .= $key . '=' . $slug;
                $values[$slug] = [$value, $this->getPDOType($value)];

                if($count < $i - 1) $sql .= ' AND ';

                ++$i;
            endforeach;
        endif;

        $sql .= $limit;

        return $sql;
    }
}

