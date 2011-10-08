<?php

namespace Selenium\Specification;

class Method
{
    const TYPE_ACCESSOR = 'accessor';
    const TYPE_ACTION   = 'action';

    protected $name;
    protected $description;
    protected $type;
    protected $parameters = array();
    protected $returnType;
    protected $returnDescription;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function addParameter(Parameter $parameter)
    {
        $this->parameters[] = $parameter;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function isAction()
    {
        return $this->type === self::TYPE_ACTION;
    }

    public function isAccessor()
    {
        return $this->type === self::TYPE_ACCESSOR;
    }

    public function setReturnType($returnType)
    {
        $this->returnType = $returnType;
    }

    public function setReturnDescription($returnDescription)
    {
        $this->returnDescription = $returnDescription;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getReturnType()
    {
        return $this->returnType;
    }

    public function getReturnDescription()
    {
        return $this->returnDescription;
    }
}
