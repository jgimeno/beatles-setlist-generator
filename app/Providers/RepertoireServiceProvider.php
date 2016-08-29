<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Repertoire\Application\Persistence\BandRepositoryInterface;
use Repertoire\Infrastructure\DoctrineBandRepository;

class RepertoireServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BandRepositoryInterface::class, DoctrineBandRepository::class);
    }
}
