<?php

declare(strict_types=1);

namespace Johnny\ImageToolKit\Facades;

use Illuminate\Support\Facades\Facade;

class ImageToolKit extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'imagetoolkit';
    }
}
