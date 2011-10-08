<?php

namespace Selenium\Specification;

class Parameter
{
    protected $name;
    protected $description;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getName()
    {
        return $this->name;
    }


}
