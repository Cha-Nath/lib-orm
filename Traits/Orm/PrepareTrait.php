<?php

namespace nlib\Orm\Traits\Orm;

use nlib\Tool\Traits\StringTrait;

trait PrepareTrait {

    use StringTrait;
    use PdoTrait;
    use ClauseTrait;

    protected function prepareParameters(array $parameters, string $type = 'where', string $delimiter = ' AND ', string $prefix = '') : array {

        $string = '';
        $binds = [];
        
        if(!empty($parameters)) :
            $i = 0;
            $count = count($parameters);
            foreach($parameters as $key => $value) :

                $slug = ':' . $prefix . $this->str_slug($key) . '_' . $i;
                $string .= $key . '=' . $slug;
                $binds[$slug] = [$value, $this->getPDOType($value)];

                if($i < ($count - 1)) $string .= $delimiter;

                ++$i;
            endforeach;
            
            if($this->inClauses('parts', $type)) $this->_parts[$type] = $this->getPart($type) . $string;
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

