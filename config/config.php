<?php 
/**
 * File configuration for TwigCachePlugin
 */
 return [
     /**
      * When this value is true, then we running Cache Strategy which doesn't cache at all!
      * this strategy prevent previously cached version from being rendered. Very useful when in development mode.
      */
    'blackholeCacheStrategyMode' => true,
    /**
     * this is default value of lifetime cache strategy, in seconds.
     */
    'octCacheStrategyLifetime' => 600,
     /** 
      * when we use model, this is the lifetime of cache in seconds.
      */
     'modelCacheStrategyLifetime' => 7200
 ];
