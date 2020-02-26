<?php

namespace nlib\Orm\Traits;

trait RepositoryTrait {

    private $_repository;

    #region Getter

    public function Repository(string $repository, string $entity) {
        if(empty($this->_repository)) $this->setRepository(new $repository);
        else $this->_repository->init($entity);
        return $this->_repository;
    }
    
    #endregion

    #region Setter

    public function setRepository($repository) : self { $this->_repository = $repository; return $this; }
    
    #endregion
}