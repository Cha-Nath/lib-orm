<?php

namespace nlib\Orm\Interfaces;

interface PrepareTraitInterface {

    /**
     *
     * @param array $sorts
     * @return self
     */
    public function prepareSorts(array $sorts);

    /**
     *
     * @param array $parts
     * @return self
     */
    public function prepareParts(array $parts);
}