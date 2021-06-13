<?php

namespace Yfktn\TwigCachePlugin;

use System\Classes\PluginBase;
use Twig\CacheExtension\CacheProvider\PsrCacheAdapter;
use Twig\CacheExtension\CacheStrategy\LifetimeCacheStrategy;
use Twig\CacheExtension\Extension as CacheExtension;
use Twig\CacheExtension\CacheStrategy\IndexedChainingCacheStrategy;
use Twig\CacheExtension\CacheStrategy\GenerationalCacheStrategy;
use Twig\CacheExtension\CacheStrategy\BlackholeCacheStrategy;
use Yfktn\TwigCachePlugin\Classes\ModelKeyGenerator;
use Cms\Classes\Controller;
use Event;

class Plugin extends PluginBase
{

    public function boot()
    {
        Event::Listen('cms.page.beforeDisplay', function (Controller $controller, $url, $page) {
            if (!config('yfktn.twigcacheplugin::blackholeCacheStrategyMode')) {
                // trace_log('blackhole not activated');
                $cacheProvider = new PsrCacheAdapter(app('cache.psr6'));
                $cacheStrategy = new IndexedChainingCacheStrategy([
                    'time' => new LifetimeCacheStrategy($cacheProvider),
                    'model' => new GenerationalCacheStrategy(
                        $cacheProvider,
                        new ModelKeyGenerator(),
                        config('yfktn.twigcacheplugin::modelCacheStrategyLifetime', 7200) /* 0 = infinite lifetime */
                    )
                ]);
                $cacheExtension = new CacheExtension($cacheStrategy);
            } else {
                // trace_log('blackhole activated');
                $cacheExtension = new CacheExtension(new BlackholeCacheStrategy());
            }

            $twig = $controller->getTwig();
            if (!$twig->hasExtension('Twig\CacheExtension\Extension')) {
                $twig->addExtension($cacheExtension);
            }
        });
    }

    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }
}