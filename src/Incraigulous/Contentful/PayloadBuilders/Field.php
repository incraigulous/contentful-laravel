<?php
namespace Incraigulous\Contentful\PayloadBuilders;

class Field implements PayloadBuilderInterface {
    protected $field;
    protected $content;
    protected $language;
    function __construct($field, $content, $language = 'en-US')
    {
        $this->field = $field;
        $this->content = $content;
        $this->defaultLanguage = $language;
    }

    /**
     * Return the payload builder array part.
     * @return array
     */
    function make()
    {
        return[$this->field => [$this->language => $this->content]];
    }
}