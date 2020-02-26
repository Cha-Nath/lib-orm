<?php

namespace nlib\Orm\Classes;

use nlib\Orm\Interfaces\HydrateTraitInterface;
use nlib\Orm\Interfaces\PropertyTraitInterface;

use nlib\Orm\Traits\HydrateTrait;
use nlib\Orm\Traits\PropertyTrait;

class Entity implements HydrateTraitInterface, PropertyTraitInterface {

    use HydrateTrait;
    use PropertyTrait;
}