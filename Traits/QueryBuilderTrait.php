<?php

namespace nlib\Orm\Traits;

use nlib\Orm\Classes\QueryBuilder;

trait QueryBuilderTrait {

    public function QueryBuilder(string $table = '') : QueryBuilder {
        return new QueryBuilder($table);
    }
}