<?php

namespace Incraigulous\Contentful;

use Cache;
use Incraigulous\ContentfulSDK\CacherInterface;

class Cacher implements CacherInterface {
    protected $tag;
    protected $time;

    function construct() {
        $this->tag = config('contentful.cacheTag');
        $this->time = config('contentful.CacheTime');
    }

    /**
     * Does the cached item exit?
     * @param $key
     * @return bool
     */
    function has($key) {
        return Cache::tags($this->tag)->has($key);
    }

    /**
     * Add an item to cache.
     * @param $key
     * @param $payload
     * @return mixed
     */
    function put($key, $payload) {
        return Cache::tags($this->tag)->put($key, $payload, $this->time);
    }

    /**
     * Get a cached item.
     * @param $key
     * @return mixed
     */
    function get($key) {
        return Cache::tags($this->tag)->get($key);
    }

    /**
     * Remove all items tagged with $this->tag from cache.
     * @return mixed
     */
    function flush() {
        return Cache::tags($this->tag)->flush();
    }
}