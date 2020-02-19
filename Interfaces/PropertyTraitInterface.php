<?php

namespace nlib\Orm\Interfaces;

interface PropertyTraitInterface {

    /**
     *
     * @param array $properties
     * @param boolean $lowercase
     * @return array
     */
    public function __getProperties(array $properties, bool $lowercase = false) : array;
}