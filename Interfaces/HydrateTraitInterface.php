<?php

namespace nlib\Orm\Interfaces;

interface HydrateTraitInterface {

    /**
     *
     * @param array $data
     * @param boolean $specialCharacters
     * @return self
     */
    public function hydrate(array $data, bool $specialCharacters = false);

    /**
     *
     * @param string $data
     * @param boolean $specialCharacters
     * @return string
     */
    public function getSetter(string $data, bool $specialCharacters = false) : string;
}