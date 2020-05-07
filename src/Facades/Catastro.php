<?php

namespace Ajtarragona\Vialer\Facades; 

use Illuminate\Support\Facades\Facade;

class Catastro extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'catastro';
    }
}
