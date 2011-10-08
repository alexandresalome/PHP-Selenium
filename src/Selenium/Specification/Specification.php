<?php

namespace Selenium\Specification;

class Specification
{
    protected $methods = array();

    public function addMethod(Method $method)
    {
        $this->methods[] = $method;
    }

    public function getMethods()
    {
        return $this->methods;
    }
}