<?php
namespace Incraigulous\Contentful\PayloadBuilders;

class Space implements PayloadBuilderInterface {
    protected $name;
    function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Return the payload builder array part.
     * @return array
     */
    function make()
    {
        return['name' => $this->name];
    }
}