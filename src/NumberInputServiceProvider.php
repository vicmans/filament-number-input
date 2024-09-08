<?php
namespace Vicmans\FilamentNumberInput;


use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class NumberInputServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-number-input';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasViews();
    }
}