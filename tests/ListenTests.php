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

class ListenTests extends TestCase {

    protected function getPackageProviders($app)
    {
        return [
            'Incraigulous\Contentful\ContentfulServiceProvider'
        ];
    }

    public function testDoesNotExist()
    {
        // given
        //
        ContentfulManagement::shouldReceive('webhooks->find->get')->once()->andThrow('Exception', 'Not Found', 404);
        $cmd = Mockery::mock('Incraigulous\Contentful\Console\Commands\Listen[option, send]');

        $cmd->shouldReceive("option")
            ->with("url")
            ->once()
            ->andReturn("adf");

        // when
        //
        $result = $cmd->exists();

        // then
        //
        $this->assertFalse($result);
    }

    public function testExists()
    {
        // given
        //
        ContentfulManagement::shouldReceive('webhooks->find->get')->once();
        $cmd = Mockery::mock('Incraigulous\Contentful\Console\Commands\Listen[option, send]');

        $cmd->shouldReceive("option")
            ->with("url")
            ->once()
            ->andReturn("adf");

        // when
        //
        $result = $cmd->exists();

        // then
        //
        $this->assertTrue($result);
    }

    public function testCreateWebhook()
    {
        // given
        //
        ContentfulManagement::shouldReceive('webhooks->put')->once();
        $cmd = Mockery::mock('Incraigulous\Contentful\Console\Commands\Listen[option, send]');

        $cmd->shouldReceive("option")
            ->with("url")
            ->once()
            ->andReturn("adf");

        // when
        //
        $cmd->create();

        // then
        //
        $this->expectOutputRegex('/created/');
    }

    public function testDeleteWebhook()
    {
        // given
        //
        ContentfulManagement::shouldReceive('webhooks->delete')->once();
        $cmd = Mockery::mock('Incraigulous\Contentful\Console\Commands\Listen[option, send]');

        $cmd->shouldReceive("option")
            ->with("url")
            ->once()
            ->andReturn("adf");

        // when
        //
        $cmd->delete();

        // then
        //
        $this->expectOutputRegex('/deleted/');
    }
}