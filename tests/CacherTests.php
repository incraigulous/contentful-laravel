<?php
/**
 * Created by PhpStorm.
 * User: craigwann1
 * Date: 3/30/15
 * Time: 9:39 PM
 */

namespace Incraigulous\Contentful\Tests;

use Incraigulous\Contentful\Cacher;
use Incraigulous\Contentful\Facades\ContentfulManagement;
use Orchestra\Testbench\TestCase;
use Mockery;
use Config;
use Cache;

class CacherTests extends TestCase {

    protected function getPackageProviders($app)
    {
        return [
            'Incraigulous\Contentful\ContentfulServiceProvider'
        ];
    }
    public function testHas()
    {
        Cache::shouldReceive('tags->has')->once()->andReturn(true);
        // given
        //
        Config::set('cache.default', 'memcached');
        $cacher = new Cacher();
        $result = $cacher->has('adsfkl');

        // then
        //
        $this->assertTrue($result);
    }

    public function testHasNoSupport()
    {
        Cache::shouldReceive('tags->has')->once()->andReturn(true);
        // given
        //
        Config::set('cache.default', 'file');
        $cacher = new Cacher();
        $result = $cacher->has('adsfkl');

        // then
        //
        $this->assertFalse($result);
    }

    public function testPut()
    {
        Cache::shouldReceive('tags->put')->once()->andReturn(true);
        // given
        //
        Config::set('cache.default', 'memcached');
        $cacher = new Cacher();
        $result = $cacher->put('adsfkl', array());

        // then
        //
        $this->assertTrue($result);
    }

    public function testPutNoSupport()
    {
        Cache::shouldReceive('tags->put')->once()->andReturn(true);
        // given
        //
        Config::set('cache.default', 'file');
        $cacher = new Cacher();
        $result = $cacher->put('adsfkl', array());

        // then
        //
        $this->assertTrue($result);
    }

    public function testGet()
    {
        Cache::shouldReceive('tags->get')->once()->andReturn(true);
        // given
        //
        Config::set('cache.default', 'memcached');
        $cacher = new Cacher();
        $result = $cacher->get('adsfkl');

        // then
        //
        $this->assertTrue($result);
    }

    public function testGetNoSupport()
    {
        Cache::shouldReceive('tags->get')->once()->andReturn(true);
        // given
        //
        Config::set('cache.default', 'file');
        $cacher = new Cacher();
        $result = $cacher->get('adsfkl');

        // then
        //
        $this->assertFalse($result);
    }

    public function testFlush()
    {
        Cache::shouldReceive('tags->flush')->once()->andReturn(true);
        // given
        //
        Config::set('cache.default', 'memcached');
        $cacher = new Cacher();
        $result = $cacher->flush('adsfkl');

        // then
        //
        $this->assertTrue($result);
    }

    public function testFlushNoSupport()
    {
        Cache::shouldReceive('tags->put')->once()->andReturn(true);
        // given
        //
        Config::set('cache.default', 'file');
        $cacher = new Cacher();
        $result = $cacher->flush('adsfkl');

        // then
        //
        $this->assertTrue($result);
    }
}