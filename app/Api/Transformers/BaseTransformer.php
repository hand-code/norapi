<?php
namespace App\Api\Transformers;

abstract class BaseTransformer
{
    public abstract function transform($item);

    public function transformCollections($items)
    {
        return array_map([$this, 'transform'], $items->toArray());
    }
}