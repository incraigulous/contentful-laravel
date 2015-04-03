<?php

namespace Incraigulous\Contentful;

use Cache;
use Incraigulous\ContentfulSDK\CacherInterface;

class Cacher implements CacherInterface {
    protected $tag;
    protected $time;
    protected $defaultCache;

    function construct() {
        $this->tag = config('contentful.cacheTag');
        $this->time = config('contentful.cacheTime');
        $this->defaultCache = config('cache.default');
    }

    /**
     * Check to see if the default cache driver supports tags.
     * @return bool
     */
    protected function supportsTags() {
        if (($this->defaultCache == 'file') || ($this->defaultCache == 'database')) return false;
        return true;
    }

    /**
     * Does the cached item exit?
     * @param $key
     * @return bool
     */
    function has($key) {
        if (!$this->supportsTags()) return false;
        return Cache::tags($this->tag)->has($key);
    }

    /**
     * Add an item to cache.
     * @param $key
     * @param $payload
     * @return mixed
     */
    function put($key, $payload) {
        if (!$this->supportsTags()) return true;
        return Cache::tags($this->tag)->put($key, $payload, $this->time);
    }

    /**
     * Get a cached item.
     * @param $key
     * @return mixed
     */
    function get($key) {
        if (!$this->supportsTags()) return false;
        return Cache::tags($this->tag)->get($key);
    }

    /**
     * Remove all items tagged with $this->tag from cache.
     * @return mixed
     */
    function flush() {
        if (!$this->supportsTags()) return true;
        return Cache::tags($this->tag)->flush();
    }
}