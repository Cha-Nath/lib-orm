<?php

namespace nlib\Orm\Traits;

interface RepositoryTraitInterface {

    /**
     *
     * @param string $repository
     * @param string $entity
     * @return mixed
     */
    public function Repository(string $repository, string $entity);
    
    /**
     *
     * @param [type] $repository
     * @return self
     */
    public function setRepository($repository);
}