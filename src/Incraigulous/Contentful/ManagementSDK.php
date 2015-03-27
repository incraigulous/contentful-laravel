<?php
/**
 * Created by PhpStorm.
 * User: craigwann1
 * Date: 3/26/15
 * Time: 9:51 PM
 */

namespace Incraigulous\Contentful;

class ManagementSDK extends DeliverySDK {

    function __construct($spaceId, $accessToken)
    {
        $this->client = new ManagementClient($spaceId, $accessToken);
        $this->requestDecorator = new RequestDecorator();
    }

}