<?php

namespace Ajtarragona\Vialer\Facades; 

use Illuminate\Support\Facades\Facade;

class Vialer extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'vialer';
    }
}
