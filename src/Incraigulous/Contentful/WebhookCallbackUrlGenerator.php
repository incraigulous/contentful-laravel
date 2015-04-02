<?php
namespace Incraigulous\Contentful;
use URL;
class WebhookCallbackUrlGenerator {
    protected $defaultWebhookCallback;
    function __construct()
    {
        $this->defaultWebhookCallback = config('contentful.defaultWebhookCallback');
    }

    /**
     * Return the webhook callback URL based on the default webhook callback setting.
     * @return string
     */
    function make()
    {
        switch (strtolower($this->defaultWebhookCallback)) {
            case 'aws':
                $hostname = file_get_contents("http://instance-data.ec2.internal/latest/meta-data/public-hostname");
                return "http://{$hostname}/contentful/flush";
        break;
            case 'laravel':
                return URL::to('/') . '/contentful/flush';
        break;
            default:
                return $this->defaultWebhookCallback;
        }
    }
}