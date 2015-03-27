<?php
namespace Incraigulous\Contentful;

use GuzzleHttp;
use Incraigulous\Contentful\ClientInterface;

class DeliveryClient extends ClientBase {
    protected $endpointBase = 'https://cdn.contentful.com/spaces/';

    /**
     * Alias for get().
     * @param $resource
     * @param array $query
     * @return mixed
     */
    function call($resource, $query = array())
    {
        return $this->get($resource, $query);
    }
}