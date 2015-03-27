<?php
namespace Incraigulous\Contentful\PayloadBuilders;

class Webhook implements PayloadBuilderInterface {
    protected $field;
    protected $content;
    protected $defaultLanguage;
    function __construct($field, $content, $defaultLanguage = 'en-US')
    {
        $this->field = $field;
        $this->content = $content;
        $this->defaultLanguage = $defaultLanguage;
    }

    /**
     * Return the payload builder array part.
     * @return array
     */
    function make()
    {
        if (is_array($this->content)) return[$this->field => $this->content];
        return[$this->field => [$this->defaultLanguage => $this->content]];
    }
}