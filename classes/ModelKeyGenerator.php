<?php namespace Yfktn\TwigCachePlugin\Classes;
/**
 * Key generator strategy for OctoberCMS Model
 */
use Twig\CacheExtension\CacheStrategy\KeyGeneratorInterface;

class ModelKeyGenerator implements KeyGeneratorInterface {

    /**
     * Get Model id and updated_at as generated key 
     */
    public function generateKey($value)
    {
        return str_replace("\\", ".", get_class($value)) . '_' . $value->id . '_' . $value->updated_at->format('YmdHis');
    }
}