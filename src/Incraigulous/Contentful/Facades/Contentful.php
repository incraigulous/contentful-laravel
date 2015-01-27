<?php namespace Incraigulous\Contentful\Facades;
use Illuminate\Support\Facades\Facade;

class Contentful extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return  string
     */
    protected static function getFacadeAccessor() { return 'contentful'; }
}