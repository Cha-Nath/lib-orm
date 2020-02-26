<?php

namespace nlib\Orm\Traits\Orm;

trait BindTrait {

    protected function bind(&$req, array $parameters = []) {

        if(!empty($parameters))
            foreach ($parameters as $key => $param)
                $req->bindValue($key, $param[0], $param[1]);

    }
}