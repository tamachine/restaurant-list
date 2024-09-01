<?php

use App\Jobs\UpdateRestaurantListJob;
use Illuminate\Support\Facades\Schedule;
use App\Services\RestaurantService;
   
Schedule::job(new UpdateRestaurantListJob(app(RestaurantService::class)))->daily();
