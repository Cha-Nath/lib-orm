<?php

namespace nlib\Orm\Interfaces;

use nlib\Orm\Classes\Entity;

interface EntityTraitInterface {

    /**
     *
     * @param string $entity
     * @return Entity
     */
    public function Entity(string $entity = '') : Entity;

    /**
     *
     * @param Entity $entity
     * @return self
     */
    public function setEntity(Entity $entity);
}