<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\RestaurantRepositoryInterface;
use App\Repositories\RestaurantRepository;
use App\Interfaces\RestaurantDataSourceInterface;
use App\Services\OverpassRestaurantDataSource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RestaurantRepositoryInterface::class, RestaurantRepository::class);
        $this->app->bind(RestaurantDataSourceInterface::class, OverpassRestaurantDataSource::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
