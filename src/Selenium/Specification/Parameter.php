<?php

namespace Selenium\Specification;

/**
 * Representation of a Selenium method parameter
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class Parameter
{
    /**
     * Name of the parameter
     *
     * @var string
     */
    protected $name;

    /**
     * Description of the parameter
     *
     * @var string
     */
    protected $description;

    /**
     * Instanciates the parameter.
     *
     * @param string $name Name of the parameter
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the description of the parameter.
     *
     * @return string The description of the parameter
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Defines the parameter description.
     *
     * @param string The parameter description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the name of the parameter.
     *
     * @return string Name of the parameter
     */
    public function getName()
    {
        return $this->name;
    }
}
