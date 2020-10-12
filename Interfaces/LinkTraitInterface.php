<?php

namespace nlib\Orm\Interfaces;

use nlib\Orm\Entity\Link;

interface LinkTraitIterface {

    /**
     *
     * @return Link
     */
    public function Link() : Link;

    /**
     *
     * @param Link $Link
     * @return self
     */
    public function setLink(Link $Link);
}