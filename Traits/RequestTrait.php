<?php

namespace nlib\Orm\Traits;

trait Request {

    protected function prepare(string &$sql, array &$values, array $parameters) {

        if(!empty($parameters))
            foreach($parameters as $key => $value)
                $sql .= $key . '=:' . $value;

        return $sql;
    }
}