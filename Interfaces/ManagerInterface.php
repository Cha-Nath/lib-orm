<?php

namespace nlib\Orm\Interfaces;

interface ManagerInterface {

    /**
     *
     * @param string $entity
     * @return self
     */
    public function init(string $entity);

    /**
     *
     * @param array $parameters
     * @return array
     */
    public function findBy(array $parameters = []) : array;

    /**
     *
     * @param array $parameters
     * @return object|null
     */
    public function findOneBy(array $parameters = []);

    /**
     *
     * @return string
     */
    public function getEntity() : string;

    /**
     *
     * @return string
     */
    public function getPrefix() : string;

    /**
     *
     * @return string
     */
    public function getTable() : string;

    /**
     *
     * @param string $entity
     * @return void
     */
    public function setEntity(string $entity);

    /**
     *
     * @param string $prefix
     * @return void
     */
    public function setPrefix(string $prefix);

    /**
     *
     * @param string $table
     * @return void
     */
    public function setTable(string $table);
}