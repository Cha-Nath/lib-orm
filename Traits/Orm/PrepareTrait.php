<?php

namespace nlib\Orm\Traits\Orm;

use nlib\Tool\Traits\StringTrait;

trait PrepareTrait {

    use StringTrait;
    use PdoTrait;
    use ClauseTrait;

    protected function prepareParameters(array $parameters) : array {

        $where = '';
        $binds = [];
        
        if(!empty($parameters)) :
            $i = 0;
            $count = count($parameters);
            foreach($parameters as $key => $value) :

                $slug = ':' . $this->str_slug($key);
                $where .= $key . '=' . $slug;
                $binds[$slug] = [$value, $this->getPDOType($value)];

                if($count < $i - 1) $where .= ' AND ';

                ++$i;
            endforeach;
            
            $this->_parts['where'] = $this->getPart('where') . $where;
        endif;

        return $binds;
    }
    
    protected function prepareCommons(array $elements, array $parameters) : array {
        foreach($parameters as $key => $value) if(in_array($key = strtolower($key), $elements)) $commons[$key] = $this->Query()->{$key}($value);
        return $commons;
    }
    
    public function prepareSorts(array $sorts) : self {
        $this->_sorts = $this->prepareCommons($this->getClauses('sorts'), $sorts);
        return $this;
    }

    public function prepareParts(array $parts) : self {
        $this->_parts = $this->prepareCommons($this->getClauses('parts'), $parts);
        return $this;
    }
}

