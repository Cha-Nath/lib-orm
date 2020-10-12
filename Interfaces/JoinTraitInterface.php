<?php

namespace nlib\Orm\Interfaces;

use nlib\Orm\Entity\Join;

interface JoinTraitIterface {

    /**
     *
     * @return Join
     */
    public function Join() : Join;

    /**
     *
     * @param Join $Join
     * @return self
     */
    public function setJoin(Join $Join);
}