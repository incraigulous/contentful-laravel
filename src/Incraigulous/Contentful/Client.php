<?php
/**
 * Created by PhpStorm.
 * User: incraigulous
 * Date: 1/16/15
 * Time: 4:16 PM
 */

namespace Incraigulous\Contentful;

use GuzzleHttp;

class Client {

    protected $client;
    private $spaceId;
    private $accessToken;
    protected $endpointBase = 'https://cdn.contentful.com/spaces/';

    function __construct($spaceId, $accessToken) {
        $this->spaceId = $spaceId;

        $this->accessToken = $accessToken;

        $this->client = new GuzzleHttp\Client();
    }

    function getClient() {
        return $this->client;
    }

    function getBearer() {
        return ' Bearer ' . $this->accessToken;
    }

    function getEndpoint() {
        return $this->endpointBase . $this->spaceId;
    }

    function call($resource, $query = array()) {
        return $this->client->get($this->build_url($resource, $query), [
            'headers' => [
                'Authorization' => $this->getBearer()
            ]
        ])->json();
    }

    function build_url($resource, $query) {
        $url = $this->getEndpoint();
        if ($resource) $url .= '/' . $resource;
        if (!empty($query)) $url .= '?' . http_build_query($query);
        return $url;
    }
}