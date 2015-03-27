<?php
/**
 * Created by PhpStorm.
 * User: craigwann1
 * Date: 3/26/15
 * Time: 10:21 PM
 */

namespace Incraigulous\Contentful;


class RequestDecorator {
    protected $request;
    protected $resource;
    protected $id;

    function __construct(array $request = array())
    {
        $this->request = $request;
    }

    function setResource($resource)
    {
        $this->resource = $resource;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function addParameter($field, $operator, $value) {
        $this->request[] = [$field, $operator, $value];
    }

    function makeQuery()
    {
        $query = array();
        foreach($this->request as $paramater) {
            $operator = ($paramater[1] != '=') ? $paramater[1] : '' ;
            $query[$paramater[0] . $operator] = $paramater[2];
        }
        return $query;
    }

    function makeResource()
    {
        $resource = $this->resource;
        if ($this->id) $resource .= '/' . $this->id;
        return $resource;
    }



}