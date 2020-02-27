<?php

namespace nlib\Orm\Interfaces;

interface DebugTraitInterface {

    /**
     *
     * @param boolean $debug
     * @param boolean $die
     * @return self
     */
    public function setDebug(bool $debug, bool $die = false);
}