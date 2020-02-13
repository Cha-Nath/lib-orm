<?php

namespace nlib\Orm\Interfaces;

use nlib\Orm\Classes\Manager;

interface ManagerTraitInterface {

    /**
     *
     * @param string $manager
     * @return Manager
     */
    public function Manager(string $manager) : Manager;

    /**
     *
     * @param Manager $manager
     * @return self
     */
    public function setManager(Manager $manager);
}