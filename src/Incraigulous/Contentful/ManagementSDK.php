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
     * Use the entries resource.
     *
     * @param null $contentType
     * @return $this
     */
    function entries($contentType = null)
    {
        $this->requestDecorator->setResource('entries');
        return $this;
    }

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
        $result = $this->client->post($this->requestDecorator->makeResource(), $this->requestDecorator->makePayload(), $this->requestDecorator->makeHeaders());
        $this->refresh();
        return $result;
    }

    /**
     * Make a put request.
     * @param $id
     * @param $payload
     * @param int $previousVersion
     * @return mixed
     */
    function put($id, $payload, $previousVersion = 0)
    {
        $this->requestDecorator->setId($id);
        $this->requestDecorator->setPayload($payload);
        if ($previousVersion) {
            $this->requestDecorator->addHeader('X-Contentful-Version', $previousVersion);
        }
        $result = $this->client->put($this->requestDecorator->makeResource(), $this->requestDecorator->makePayload(), $this->requestDecorator->makeHeaders());
        $this->refresh();
        return $result;
    }

    /**
     * Make a delete request.
     * @param $id
     * @return mixed
     */
    function delete($id)
    {
        $this->requestDecorator->setId($id);
        $result = $this->client->delete($this->requestDecorator->makeResource(), $this->requestDecorator->makeHeaders());
        $this->refresh();
        return $result;
    }

    /**
     * Publish a record.
     * @param $id
     * @param $previousVersion
     * @return mixed
     */
    function publish($id, $previousVersion)
    {
        $this->requestDecorator->setId($id  . '/published');
        $this->requestDecorator->addHeader('X-Contentful-Version', $previousVersion);
        $result = $this->client->put($this->requestDecorator->makeResource(), $this->requestDecorator->makePayload(), $this->requestDecorator->makeHeaders());
        $this->refresh();
        return $result;
    }

    /**
     * Unublish a record.
     * @param $id
     * @param $previousVersion
     * @return mixed
     */
    function unpublish($id, $previousVersion)
    {
        $this->requestDecorator->setId($id  . '/published');
        $this->requestDecorator->addHeader('X-Contentful-Version', $previousVersion);
        $result = $this->client->delete($this->requestDecorator->makeResource(), $this->requestDecorator->makePayload(), $this->requestDecorator->makeHeaders());
        $this->refresh();
        return $result;
    }

    /**
     * Archive a record.
     * @param $id
     * @return mixed
     */
    function archive($id)
    {
        $this->requestDecorator->setId($id  . '/archived');
        $result = $this->client->put($this->requestDecorator->makeResource(), $this->requestDecorator->makePayload(), $this->requestDecorator->makeHeaders());
        $this->refresh();
        return $result;
    }

    /**
     * Unarchive a record.
     * @param $id
     * @return mixed
     */
    function unarchive($id)
    {
        $this->requestDecorator->setId($id  . '/archived');
        $result = $this->client->delete($this->requestDecorator->makeResource(), $this->requestDecorator->makePayload(), $this->requestDecorator->makeHeaders());
        $this->refresh();
        return $result;
    }

    /**
     * Process an asset.
     * @param $id
     * @param string $language
     * @return mixed
     */
    function process($id, $language = 'en-US')
    {
        $this->requestDecorator->setId($id  . '/files/' . $language . '/process');
        $result = $this->client->delete($this->requestDecorator->makeResource(), $this->requestDecorator->makePayload(), $this->requestDecorator->makeHeaders());
        $this->refresh();
        return $result;
    }

}