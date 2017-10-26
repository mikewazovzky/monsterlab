<?php

namespace App;

use Illuminate\Support\Facades\Redis;

/**
 * Tracks views count for the model and provides array of the most popular (viewed) models.
 * Stores key =>member:score combination as Redis sorted list
 *
 * @trait TrackViewsCount
 */
trait Cacheable
{
    /**
     * Clear model views count, when model is deleted
     * via model 'deleted' event handler
     */
    public static function bootCacheable()
    {
        static::deleted(function ($post) {
            $post->clearViewsCount();
        });
    }
    /**
     * Increment views count for the model instance (member).
     *
     * @return void
     */
    public function incrementViewsCount()
    {
        Redis::zincrby(static::cacheKey(), 1, $this->cacheData());
    }

    /**
     * Get view count for the model instance (member).
     *
     * @return integer
     */
    public function getViewsCount()
    {
        return Redis::zscore(static::cacheKey(), $this->cacheData());
    }

    /**
     * Get views count for the model instance (member) as attribute.
     *
     * @return integer
     */
    public function getViewsCountAttribute()
    {
        return $this->getViewsCount();
    }

    /**
     * Clear views count for the model instance (member).
     *
     * @param type name
     * @return type
     */
    public function clearViewsCount()
    {
        return Redis::zrem(static::cacheKey(), $this->cacheData());
    }

    /**
     * Clear all views count for the model class (key).
     *
     * @return void
     */
    public static function resetViewsCount()
    {
        Redis::del(static::cacheKey());
    }

    /**
     * Get most popular (trending) items sorted by views count
     *
     * @param integer $limit - numbe of items in trending array
     * @return array of StdObjects
     */
    public static function trending($limit = 0)
    {
        $data = array_map('json_decode', Redis::zrevrange(static::cacheKey(), 0, $limit - 1));
        return $data;
    }

    /**
     * Define cache key for the model type (class)
     *
     * @return string
     */
    protected static function cacheKey()
    {
        $name = static::className();
        $key = (app()->environment() === 'testing') ? "trending_{$name}s_testing" : "trending_{$name}s";
        return $key;
    }

    /**
     * Encode data to be cached for the given model instance (member).
     *
     * @param type name
     * @return type
     */
    public function cacheData()
    {
        return json_encode(
            $this->toCacheableArray()
        );
    }

    public function toCacheableArray()
    {
        return $this->toArray();
    }

    /**
     * Get short lowercased class name for the model
     *
     * @param type name
     * @return type
     */
    protected static function className()
    {
        $name = (new \ReflectionClass(static::class))->getShortName();
        return strtolower($name);
    }
}
