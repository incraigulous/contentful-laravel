<?php
/**
 * Created by PhpStorm.
 * User: craigwann1
 * Date: 3/30/15
 * Time: 9:39 PM
 */

namespace Incraigulous\Contentful\Tests;

use Incraigulous\Contentful\WebhookCallbackUrlGenerator;
use Orchestra\Testbench\TestCase;
use Mockery;
use Config;
use URL;

class CallbackGeneratorTests extends TestCase {

    public function testLaravel()
    {
        // given
        //
        Config::set('contentful.WebhookUrlBase', 'laravel');
        Config::set('contentful.WebhookUrlSuffix', '/contentful/flush');

        URL::shouldReceive('to')->once()->andReturn('http://www.google.com');

        $generator = new WebhookCallbackUrlGenerator();
        $callback = $generator->make();

        // then
        //
        $this->assertEquals($callback, 'http://www.google.com/contentful/flush');
    }

    public function testCustom()
    {
        // given
        //
        Config::set('contentful.WebhookUrlBase', 'http://www.google.com');
        Config::set('contentful.WebhookUrlSuffix', '/contentful/flush');

        $generator = new WebhookCallbackUrlGenerator();
        $callback = $generator->make();

        // then
        //
        $this->assertEquals($callback, 'http://www.google.com/contentful/flush');
    }
}