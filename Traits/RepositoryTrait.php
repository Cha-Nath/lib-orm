<?php

namespace nlib\Orm\Traits;

trait RepositoryTrait {

    private $_repository;

    #region Getter

    public function Repository(string $repository, string $entity) {
        if(empty($this->_repository)) $this->setRepository(new $repository);
        return $this->_repository->init($entity);
    }
    
    #endregion

    #region Setter

    public function setRepository($repository) : self { $this->_repository = $repository; return $this; }
    
    #endregion
}