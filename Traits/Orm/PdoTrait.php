<?php

namespace nlib\Orm\Traits\Orm;

use PDO;

trait PdoTrait {

    protected function getPDOType($value) : int {
        $type = PDO::PARAM_STR;
        if(is_int($value)) $type = PDO::PARAM_INT;
        return $type;
    }
}