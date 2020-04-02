# Twig Cache Plugin for OctoberCMS

Add [twig cache plugin extension](https://github.com/twigphp/twig-cache-extension) to octoberCMS.

## Before installing This Plugin:
You need to add 2 package into the *require* part of **composer.json** of OctoberCMS before installing this plugin.

```
"twig/cache-extension": "~1.0",
"madewithlove/illuminate-psr-cache-bridge": "^1.0"
```

And then run composer to install those package.

```
$ composer install --no-dev
```
## Installing The Plugin

```
$ cd octobercmsprojectpath/plugins
$ mkdir yfktn
$ git clone https://github.com/yfktn/twigcache-plugin.git twigcache-plugin
```

## How To Use

This plugin currently implement the ```IndexedChainingCacheStrategy()```, with **time** (```LifetimeCacheStrategy()```) and **model** (```GenerationalCacheStrategy()```) as index to access when we need to implement related strategy.

To use it, in your twig template, surround the code with a **cache** block at the part you want to cache.

Let say we have part of our homepage that we need to cache, and it would expired in 120 seconds, then our code would be:

```
{# add homepage annotation with time strategy, for 10 seconds #}
{% cache "homepage" {time: 10} %}
    {# heavy lifting template stuff here, include/render other partials etc #}
{% endcache %}
``` 

In another case, you have view to show detail of Eloquent database model and it would expired in 7200 seconds or when our model updated (*since the cache strategy need **created_at** field in your model as Carbon object to generated cache key, you need to make custom mutator if it doesn't exist*), then our code would be:

```
{# add model annotation #}
{% set annotmodel = "model" ~ post.id %}
{% cache annotmodel {model: post} %}
    {# heavy lifting template stuff here, include/render other partials etc #}
{% endcache %}
``` 

If you like to add another cache strategy, you may check the code at ```Yfktn\TwigCachePlugin\Classes\ModelKeyGenerator``` as the example, or write your own psr6 driver.

For more information please consult to [twig cache plugin extension](https://github.com/twigphp/twig-cache-extension) page.