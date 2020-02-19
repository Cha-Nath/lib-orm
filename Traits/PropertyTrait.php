<?php

namespace nlib\Orm\Traits;

trait PropertyTrait {

    public function __getProperties(array $properties, bool $lowercase = false) : array {

        $results = [];
        $replace = 1;

        foreach ($properties as $key => $value) :
            if($lowercase) $key = strtolower($key);
            $results[str_replace('_', '', $key, $replace)] = $value;        
        endforeach;

        return $results;
    }
}