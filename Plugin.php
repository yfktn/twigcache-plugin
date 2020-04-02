<?php namespace Yfktn\TwigCachePlugin;

use System\Classes\PluginBase;
use Twig\CacheExtension\CacheProvider\PsrCacheAdapter;
use Twig\CacheExtension\CacheStrategy\LifetimeCacheStrategy;
use Twig\CacheExtension\Extension as CacheExtension;
use Twig\CacheExtension\CacheStrategy\IndexedChainingCacheStrategy;
use Twig\CacheExtension\CacheStrategy\GenerationalCacheStrategy;
use Madewithlove\IlluminatePsrCacheBridge\Laravel\CacheItemPool;
use Illuminate\Contracts\Cache\Repository;
use Yfktn\TwigCachePlugin\Classes\ModelKeyGenerator;
use Cms\Classes\Controller;
use Event;

class Plugin extends PluginBase
{

    public function boot()
    {
        \Event::Listen('cms.page.beforeDisplay', function (Controller $controller, $url, $page) {

            $repository = \App::make(Repository::class);
            $cacheProvider = new PsrCacheAdapter(new CacheItemPool($repository));
            $cacheStrategy = new IndexedChainingCacheStrategy([
                'time' => new LifetimeCacheStrategy($cacheProvider),
                'model' => new GenerationalCacheStrategy(
                    $cacheProvider, 
                    new ModelKeyGenerator(), 
                    7200 /* 0 = infinite lifetime */)
            ]);
            $cacheExtension = new CacheExtension($cacheStrategy);

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
