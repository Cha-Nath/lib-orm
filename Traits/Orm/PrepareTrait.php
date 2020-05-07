<?php

namespace nlib\Orm\Traits\Orm;

use nlib\Tool\Traits\StringTrait;

trait PrepareTrait {

    use StringTrait;
    use PdoTrait;
    use ClauseTrait;

    protected function prepareParameters(array $parameters, string $type = 'where', string $delimiter = ' AND ', string $prefix = '', bool $into = false) : array {

        $string = '';
        $binds = [];
        $skey = $svalue = '';
        
        if(!empty($parameters)) :
            $i = 0;
            $count = count($parameters);
            foreach($parameters as $key => $value) :

                $slug = ':' . $prefix . $this->str_slug($key, '_') . '_' . $i;

                if(!$into) :
                    $string .= $key . '=' . $slug;
                    if($i < ($count - 1)) : $string .= $delimiter; endif;
                else : 
                    $skey .= $key;
                    $svalue .= $slug;

                    if($i < ($count - 1)) : $skey .= ', '; $svalue .= ', '; endif;
                endif;

                $binds[$slug] = [$value, $this->getPDOType($value)];

                ++$i;
            endforeach;
            
            if($this->inClauses('parts', $type)) $this->_parts[$type] = $into
                ? str_replace(['{key}', '{value}'], [$skey, $svalue], $this->getPart($type)) : $this->getPart($type) . $string;
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

