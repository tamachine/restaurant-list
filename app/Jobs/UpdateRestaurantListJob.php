<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\RestaurantService;

/**
 * Job for updating the list of restaurants.
 */
class UpdateRestaurantListJob implements ShouldQueue
{
    use Queueable;

    protected $restaurantService;

    /**
     * Create a new job instance.
     *
     * @param RestaurantService $restaurantService The service used to update the restaurant list.
     */
    public function __construct(RestaurantService $restaurantService)
    {
        $this->restaurantService = $restaurantService;
    }

    /**
     * Create a new job instance.
     *
     * @param RestaurantService $restaurantService The service used to update the restaurant list.
     */
    public function handle(): void
    {        
        $this->restaurantService->updateRestaurantList();
    }
}
