<?php

namespace nlib\Orm\Traits;

trait HydrateTrait {

    public function hydrate(array $data, bool $specialCharacters = false) : self {
        
        if(!empty($data)) :

            foreach ($data as $key => $value) :
                
                $methodName = $this->getSetter($key, $specialCharacters);
                
                if(method_exists($this, $methodName)) $this->$methodName($value);
            endforeach;
        endif;

        return $this;
    }

    public function getSetter(string $data, bool $specialCharacters = false) : string {
        $return = 'set';
        $return .= (!empty($specialCharacters)) ? $data : str_replace(array('_', '-'), '', $data);
        return $return;
    }
}