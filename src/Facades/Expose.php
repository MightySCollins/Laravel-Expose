<?php

namespace SCollins\LaravelExpose\Facades;

use Illuminate\Support\Facades\Facade;

class Expose extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'expose';
    }
}
