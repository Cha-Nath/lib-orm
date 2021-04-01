<?php

namespace nlib\Orm\Traits;

trait PropertyTrait {

    public function __getProperties(array $properties, bool $lowercase = false, bool $nullable = true) : array {

        $results = [];
        $replace = 1;

        foreach ($properties as $key => $value) :
            if(!$nullable && !(!empty($value) || is_numeric($value) || is_bool($value))) continue;
            
            if($lowercase) $key = strtolower($key);
            $results[str_replace('_', '', $key, $replace)] = $value;        
        endforeach;

        return $results;
    }
}