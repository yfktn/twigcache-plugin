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
     'modelCacheStrategyLifetime' => 7200
 ];
