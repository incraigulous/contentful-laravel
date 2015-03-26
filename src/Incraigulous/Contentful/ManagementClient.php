<?php
namespace Incraigulous\Contentful;

use GuzzleHttp;
use Incraigulous\Contentful\ClientInterface;

class ManagementClient extends ClientBase {
    protected $endpointBase = 'https://api.contentful.com/spaces/';
}