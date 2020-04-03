<?php namespace Yfktn\TwigCachePlugin;

use System\Classes\PluginBase;
use Twig\CacheExtension\CacheProvider\PsrCacheAdapter;
use Twig\CacheExtension\CacheStrategy\LifetimeCacheStrategy;
use Twig\CacheExtension\Extension as CacheExtension;
use Twig\CacheExtension\CacheStrategy\IndexedChainingCacheStrategy;
use Twig\CacheExtension\CacheStrategy\GenerationalCacheStrategy;
use Twig\CacheExtension\CacheStrategy\BlackholeCacheStrategy;
use Madewithlove\IlluminatePsrCacheBridge\Laravel\CacheItemPool;
use Illuminate\Contracts\Cache\Repository;
use Yfktn\TwigCachePlugin\Classes\ModelKeyGenerator;
use Cms\Classes\Controller;
use Event;

class Plugin extends PluginBase
{

    public function boot()
    {
        Event::Listen('cms.page.beforeDisplay', function (Controller $controller, $url, $page) {
            if( config('Yfktn.TwigCachePlugin::blackholeCacheStrategyMode', false) ) {
                // trace_log('blackhole not activated');
                $repository = \App::make(Repository::class);
                $cacheProvider = new PsrCacheAdapter(new CacheItemPool($repository));
                $cacheStrategy = new IndexedChainingCacheStrategy([
                    'time' => new LifetimeCacheStrategy($cacheProvider),
                    'model' => new GenerationalCacheStrategy(
                        $cacheProvider, 
                        new ModelKeyGenerator(), 
                        config('Yfktn.TwigCachePlugin::modelCacheStrategyLifetime', 7200) /* 0 = infinite lifetime */)
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
