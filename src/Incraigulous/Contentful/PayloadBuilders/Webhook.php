<?php
namespace Incraigulous\Contentful\PayloadBuilders;

class Webhook implements PayloadBuilderInterface {
    protected $url;
    function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Return the payload builder array part.
     * @return array
     */
    function make()
    {
        return array('url' => $this->url);
    }
}