<?php

namespace Selenium\Specification\Dumper;

class MethodBuilder
{
    protected $documentation;
    protected $name;
    protected $body;
    protected $parameters = array();

    public function setDocumentation($documentation)
    {
        $this->documentation = $documentation;

        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    public function addParameter($parameter)
    {
        $this->parameters[] = '$'.$parameter;

        return $this;
    }

    public function buildCode()
    {
        $code = '';

        if ($this->documentation) {
            $code .= '    /**'."\n";
            $code .= '     * '.str_replace("\n", "\n     * ", $this->wrap($this->documentation))."\n";
            $code .= '     */'."\n";
        }

        $code .= '    public function '.$this->name.'('.implode(', ', $this->parameters).')'."\n";
        $code .= '    {'."\n";
        $code .= '        '.str_replace("\n", "\n        ", $this->body)."\n";
        $code .= '    }';

        return $code;
    }

    protected function wrap($text, $width = 73)
    {
        return wordwrap($text, 73);
    }
}
