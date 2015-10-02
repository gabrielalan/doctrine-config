<?php

namespace Entities;

/**
 * @Entity 
 * @Table(name="products")
 */
class Product extends Entity
{
    /**
     * @Id @Column(type="integer") 
     * @GeneratedValue
     */
    protected $id;
    /**
     * @Column(type="string")
     */
    protected $name;
    /**
     * @Column(type="text", nullable=true)
     */
    protected $description;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}