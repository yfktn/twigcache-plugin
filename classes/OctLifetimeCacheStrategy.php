<?php
namespace Yfktn\TwigCachePlugin\Classes;

use Twig\CacheExtension\CacheProviderInterface;
use Twig\CacheExtension\CacheStrategy\LifetimeCacheStrategy;
use Twig\CacheExtension\Exception\InvalidCacheLifetimeException;

/**
 * We need to add lifetime with config 
 * @package Yfktn\TwigCachePlugin\Classes
 */
class OctLifetimeCacheStrategy extends LifetimeCacheStrategy
{
    private $lifetime;

    /**
     * {@inheritDoc}
     */
    public function __construct(CacheProviderInterface $cache, $lifetime = 0)
    {
        $this->lifetime = $lifetime;
        parent::__construct($cache);
    }

    /**
     * if $value is null then use default value of lifetime
     */
    public function generateKey($annotation, $value) 
    { 
        $lifetime = $this->lifetime; // default
        if(!is_numeric($value)) {
            if($value != null) {
                throw new InvalidCacheLifetimeException($value);
            }
        } else {
            $lifetime = $value;
        }

        return [
            'lifetime' => $lifetime,
            'key'      => '__OLCS__' . $annotation
        ];
    }

}