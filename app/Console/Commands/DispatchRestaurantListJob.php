<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\UpdateRestaurantListJob;
use App\Services\RestaurantService;

/**
 * This Artisan command is responsible for dispatching a job to update the restaurant list.
 */
class DispatchRestaurantListJob extends Command
{
    
    protected $signature = 'app:update-restaurant-list-job';  

    protected $description = 'Updates restaurant list';

    /**
     * Execute the console command.
     *     
     * @param RestaurantService $restaurantService 
     * 
     * @return void
     */
    public function handle(RestaurantService $restaurantService)
    {
        dispatch(new UpdateRestaurantListJob($restaurantService));
        
        $this->info('The update restaurant list job has been dispatched.');
        
    }
}
