# Twig Cache Plugin for OctoberCMS

## Before Installing This Plugin:
You need to add 2 package into the *require* part of **composer.json** of OctoberCMS before installing this plugins into your project.

```
"twig/cache-extension": "~1.0",
"madewithlove/illuminate-psr-cache-bridge": "^1.0"
```

And then run composer to install those package.

```
$ composer install --no-dev
```

After that, in your twig template, surround the code with a **cache** block at the part you want to cache.

```
{# add homepage annotation for 10 seconds #}
{% cache "homepage" 10 %}
    {# heavy lifting template stuff here, include/render other partials etc #}
{% endcache %}
```

This plugin currently implement the ```LifetimeCacheStrategy()```, for other cache strategy please read twig/cache-extension readme file.
