# OctoberCMS Plugin to use Twig Cache Extension

Add [twig cache plugin extension](https://github.com/twigphp/twig-cache-extension) to octoberCMS.

## Installing The Plugin

Since v0.0.6 we can installing the plugin from composer. From the root of octobercms path:

```
$ composer require yfktn/twigcacheplugin
```

You need to use version v0.1 for OctoberCMS version 1.1.

## How To Use

This plugin currently implement the ```IndexedChainingCacheStrategy()```, with **time** (```LifetimeCacheStrategy()```) and **model** (```GenerationalCacheStrategy()```) as index to access when we need to implement related strategy.

To use it, in your twig template, surround the code with a **cache** block at the part you want to cache.

Let say we have part of our homepage that we need to cache, and it would expired in 120 seconds, then our code would be:

```
{# add homepage annotation with time strategy, for 120 seconds #}
{% cache "homepage" {time: 120} %}
    {# heavy lifting template stuff here, include/render other partials etc #}
{% endcache %}
``` 
Or if you want to use value of ```octCacheStrategyLifetime```, you can use ```null``` value instead of 120.

In another case, you have view to show detail of Eloquent database model and it would expired in 7200 seconds or when our model updated (*since the cache strategy need **created_at** field in your model as Carbon object to generated cache key, you need to make custom mutator if it doesn't exist*), then our code would be:

```
{# add model annotation #}
{% set annotmodel = "model" ~ post.id %}
{% cache annotmodel {model: post} %}
    {# heavy lifting template stuff here, include/render other partials etc #}
{% endcache %}
``` 

## Blackhole Cache Strategy

When you are in development mode, you don't need twig loading previous generated cache to view. In the configuration file you can change value of *blackholeCacheStrategyMode* to true, this strategy prevents previously caching version from being rendered.

**True** is the default value of ```blackholeCacheStrategyMode``` and **you MUST** set this value to **false** when deploying it in your production server.

For more information about twig cache plugin extension please consult to [twig cache plugin extension](https://github.com/twigphp/twig-cache-extension) page.

Note: My plugin is in early stages of its development, please use with care.
