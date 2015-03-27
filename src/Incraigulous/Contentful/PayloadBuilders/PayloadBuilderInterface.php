<?php
namespace Incraigulous\Contentful\PayloadBuilders;

interface PayloadBuilderInterface {
    /**
     * return the payload builder array part.
     * @return mixed
     */
    function make();
}