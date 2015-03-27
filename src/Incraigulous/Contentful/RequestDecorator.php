<?php
/**
 * Created by PhpStorm.
 * User: craigwann1
 * Date: 3/26/15
 * Time: 10:21 PM
 */

namespace Incraigulous\Contentful;

use Incraigulous\Contentful\PayloadBuilders\PayloadBuilderInterface;

class RequestDecorator {
    protected $query;
    protected $resource;
    protected $payload;
    protected $id;

    function __construct(array $request = array())
    {
        $this->query = $request;
    }

    /**
     * Set the resource.
     * @param $resource
     */
    function setResource($resource)
    {
        $this->resource = $resource;
    }

    /**
     * Set the request ID.
     * @param $id
     */
    function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Add a GET request query string paramater.
     * @param $field
     * @param $operator
     * @param $value
     */
    function addParameter($field, $operator, $value)
    {
        $this->query[] = [$field, $operator, $value];
    }

    /**
     * Set the payload. Can be a PayloadBuilder Object, an array, or an array with PayloadBuilder object parts.
     * @param $payload
     */
    function setPayload($payload)
    {
        $this->payload = $this->buildPayload($payload);
    }

    /**
     * Parse the payload to check for PayloadBuilder objects and make them.
     * @param $payload
     * @return array
     */
    function buildPayload($payload)
    {
        if (is_array($payload)) {
            array_walk_recursive($payload, array($this, 'buildPayloadItem'));
        } else {
            $payload = $this->makePayloadBuilder($payload);
        }
        return $payload;
    }

    /**
     * The array_walk_recursive callback for buildPayload. If the array part is an object, it attempts to make payloadBuilder.
     * @param $item
     * @param $key
     */
    function buildPayloadItem(&$item, $key)
    {
        if (is_object($item)) {
            $item = $this->makePayloadDecorator($item);
        }
    }

    /**
     * Make a payloadBuilder object.
     * @param PayloadBuilderInterface $payloadBuilder
     * @return mixed
     */
    function makePayloadBuilder(PayloadBuilderInterface $payloadBuilder)
    {
        return $payloadBuilder->make();
    }

    /**
     * Return an array ready to be http encoded.
     * @return array
     */
    function makeQuery()
    {
        $query = array();
        foreach($this->query as $paramater) {
            $operator = ($paramater[1] != '=') ? $paramater[1] : '' ;
            $query[$paramater[0] . $operator] = $paramater[2];
        }
        return $query;
    }

    /**
     * Return the payload.
     * @return mixed
     */
    function makePayload() {
        return $this->payload;
    }

    /**
     * Return the resource url part.
     * @return string
     */
    function makeResource()
    {
        $resource = $this->resource;
        if ($this->id) $resource .= '/' . $this->id;
        return $resource;
    }
}