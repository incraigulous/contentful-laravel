<?php
namespace Incraigulous\Contentful;

use GuzzleHttp;
use Incraigulous\Contentful\ClientInterface;

class ManagementClient extends ClientBase {
    protected $endpointBase = 'https://api.contentful.com/spaces/';

    /**
     * Get the content type for post/put requests.
     * @return string
     */
    function getContentType() {
        return "application/vnd.contentful.management.v1+json'";
    }

    /**
     * Build and make a POST request.
     * @param $resource
     * @param array $query
     * @return GuzzleHttp\Message\FutureResponse|GuzzleHttp\Message\ResponseInterface|GuzzleHttp\Ring\Future\FutureInterface|mixed|null
     */
    function post($resource, $query = array()) {
        return $this->client->post($this->build_url($resource), [
            'headers' => [
                'Content-Type' => $this->getContentType(),
                'Authorization' => $this->getBearer(),
            ],
            'body' => [
                json_encode($query)
            ]
        ]);
    }

    /**
     * Build and make a PUT request.
     * @param $resource
     * @param array $query
     * @return GuzzleHttp\Message\FutureResponse|GuzzleHttp\Message\ResponseInterface|GuzzleHttp\Ring\Future\FutureInterface|mixed|null
     */
    function put($resource, $query = array()) {
        return $this->client->put($this->build_url($resource), [
            'headers' => [
                'Content-Type' => $this->getContentType(),
                'Authorization' => $this->getBearer(),
            ],
            'body' => [
                json_encode($query)
            ]
        ]);
    }

    /**
     * Build and make a DELETE request.
     * @param $resource
     * @return GuzzleHttp\Message\FutureResponse|GuzzleHttp\Message\ResponseInterface|GuzzleHttp\Ring\Future\FutureInterface|mixed|null
     */
    function delete($resource) {
        return $this->client->put($this->build_url($resource), [
            'headers' => [
                'Authorization' => $this->getBearer(),
            ]
        ]);
    }
}