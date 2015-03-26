<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 3/26/15
 * Time: 4:41 PM
 */

namespace Incraigulous\Contentful;


interface ClientInterface {
    /**
     * Get the Guzzle Client.
     * @return GuzzleHttp\Client
     */
    function getClient();

    /**
     * Format the authorization header.
     * @return string
     */
    function getBearer();

    /**
     * Get the endpoint.
     * @return string
     */
    function getEndpoint();

    /**
     * Make a get request.
     * @param $resource
     * @param array $query
     * @return mixed
     */
    function get($resource, $query = array());

    /**
     * Build the query URL.
     * @param $resource
     * @param $query
     * @return string
     */
    function build_url($resource, $query);
}