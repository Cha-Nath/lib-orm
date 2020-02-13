<?php

namespace nlib\Orm\Classes;

use nlib\Orm\Traits\HydrateTrait;
use nlib\Orm\Interfaces\EntityInterface;
use nlib\Orm\Interfaces\HydrateTraitInterface;

class Entity implements EntityInterface, HydrateTraitInterface {

    use HydrateTrait;
}