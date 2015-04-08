<?php
namespace Incraigulous\Contentful;
use URL;

class WebhookCallbackUrlGenerator {
    protected $WebhookUrlBase;
    protected $WebhookUrlSuffix;

    function __construct()
    {
        $this->WebhookUrlBase = config('contentful.WebhookUrlBase');
        $this->WebhookUrlSuffix = config('contentful.WebhookUrlSuffix');
    }

    /**
     * Return the webhook callback URL based on the webhook url config settings.
     * @return string
     */
    function make()
    {
        switch (strtolower($this->WebhookUrlBase)) {
            case 'aws':
                $hostname = file_get_contents("http://instance-data.ec2.internal/latest/meta-data/public-hostname");
                return "http://" . $hostname . $this->WebhookUrlSuffix;
                break;
            case 'laravel':
                return URL::to('/') . $this->WebhookUrlSuffix;
                break;
            default:
                return $this->WebhookUrlBase . $this->WebhookUrlSuffix;
        }
    }
}