<?php
/**
 * Created by PhpStorm.
 * User: craigwann1
 * Date: 3/30/15
 * Time: 9:39 PM
 */

namespace Incraigulous\Contentful\Tests;

use Incraigulous\Contentful\Console\Commands\CreateWebhook;
use Incraigulous\Contentful\Facades\ContentfulManagement;
use Orchestra\Testbench\TestCase;
use Mockery;

class CreateWebhookTests extends TestCase {

    protected function getPackageProviders($app)
    {
        return [
            'Incraigulous\Contentful\ContentfulServiceProvider'
        ];
    }
    public function testCreateWebhook()
    {
        // given
        //
        ContentfulManagement::shouldReceive('webhooks->post')->once();
        $cmd = Mockery::mock('Incraigulous\Contentful\Console\Commands\CreateWebhook[option, send]');

        $cmd->shouldReceive("option")
            ->with("url")
            ->once()
            ->andReturn("adf");

        // when
        //
        $cmd->fire();

        // then
        //
        $this->assertTrue(true);
    }
}