<?php

namespace Lnext\AuxiliarySolutions;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Lnext\AuxiliarySolutions\Console\Maker\FacadeSingleton;
use Lnext\AuxiliarySolutions\Console\Maker\OwnSeeder;
use Lnext\AuxiliarySolutions\Console\Maker\SingletonArrayBoxClass;
use Lnext\AuxiliarySolutions\Console\Maker\SingletonClass;
use Lnext\AuxiliarySolutions\Console\Singleton;

class ServiceCommandProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(): void
    {
       //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->commands(
            [
                Singleton::class,
                FacadeSingleton::class,
                OwnSeeder::class,
                SingletonArrayBoxClass::class,
                SingletonClass::class,
            ]
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            Singleton::class,
            FacadeSingleton::class,
            OwnSeeder::class,
            SingletonArrayBoxClass::class,
            SingletonClass::class,
        ];
    }
}
