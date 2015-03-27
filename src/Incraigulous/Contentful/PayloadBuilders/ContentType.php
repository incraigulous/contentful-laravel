<?php
namespace Incraigulous\Contentful\PayloadBuilders;

class ContentType implements PayloadBuilderInterface {
    protected $name;
    protected $displayField;
    protected $contentTypeFields;

    function __construct($name, $displayField, $contentTypeFields)
    {
        $this->name = $name;
        $this->displayField = $displayField;
        $this->contentTypeFields = $contentTypeFields;
    }

    /**
     * Return the payload builder array part.
     * @return array
     */
    function make()
    {
        return[
            'name' => $this->name,
            'displayField' => $this->displayField,
            'fields' => $this->contentTypeFields
        ];
    }
}