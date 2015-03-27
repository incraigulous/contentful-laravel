<?php
/**
 * Created by PhpStorm.
 * User: craigwann1
 * Date: 3/26/15
 * Time: 9:51 PM
 */

namespace Incraigulous\Contentful;

class ManagementSDK extends SDKBase {
    protected $clientClassName = 'Incraigulous\Contentful\ManagementClient';

    /**
     * Use the webhook_definitions resource.
     * @return $this
     */
    function webhook()
    {
        $this->requestDecorator->setResource('webhook_definitions');
        return $this;
    }

    /**
     * Alias for $this->webhook().
     * @return ManagementSDK
     */
    function webhookDefinitions()
    {
        return $this->webhook();
    }

    /**
     * Make a post request.
     * @param $payload
     * @return mixed
     */
    function post($payload)
    {
        $this->requestDecorator->setPayload($payload);
        return $this->client->post($this->requestDecorator->makeResource(), $this->requestDecorator->makePayload());
    }

    /**
     * Make a put request.
     * @param $id
     * @param $payload
     * @return mixed
     */
    function put($id, $payload)
    {
        $this->requestDecorator->setId($id);
        $this->requestDecorator->setPayload($payload);
        return $this->client->put($this->requestDecorator->makeResource(), $this->requestDecorator->makePayload());
    }

    /**
     * Make a delete request.
     * @param $id
     * @return mixed
     */
    function delete($id)
    {
        $this->requestDecorator->setId($id);
        return $this->client->delete($this->requestDecorator->makeResource());
    }
}