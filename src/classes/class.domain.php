<?php

/**
 * Class DomainObjectAbstract
 * Implementação de domínio
 */
abstract class DomainObjectAbstract
{
    protected $_id = null;

    /**
     * Get the ID of this object (unique to the
     * object type)
     *
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Set the id for this object.
     *
     * @param int $id
     * @return int
     * @throws Exception If the id on the object is already set
     */
    public function setId($id)
    {
        if (!is_null($this->_id)) {
            throw new Exception('ID is immutable');
        }
        return $this->_id = $id;
    }
}