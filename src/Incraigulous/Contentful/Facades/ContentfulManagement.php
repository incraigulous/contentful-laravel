<?php namespace Incraigulous\Contentful\Facades;
use Illuminate\Support\Facades\Facade;

class ContentfulManagement extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return  string
     */
    protected static function getFacadeAccessor() { return 'contentfulManagement'; }
}