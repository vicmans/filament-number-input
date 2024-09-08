<?php

namespace Vicmans\FilamentNumberInput\Facades;

use Illuminate\Support\Facades\Facade;

class NumberInput extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'number-input';
    }
}