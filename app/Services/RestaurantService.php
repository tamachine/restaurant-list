<?php

namespace App\Services;

use App\Interfaces\RestaurantRepositoryInterface;
use App\Interfaces\RestaurantDataSourceInterface;

/**
 * Service class for managing restaurants.
 */
class RestaurantService
{
    protected RestaurantRepositoryInterface $RestaurantRepository;
    protected RestaurantDataSourceInterface $restaurantDataSource;

    public function __construct(RestaurantRepositoryInterface $RestaurantRepository, RestaurantDataSourceInterface $restaurantDataSource)
    {
        $this->RestaurantRepository = $RestaurantRepository;
        $this->restaurantDataSource = $restaurantDataSource;
    }

    /**
     * Update the list of restaurants from the data source.
     *
     * @return void
     */
    public function updateRestaurantList()
    {
        $restaurants = $this->restaurantDataSource->getRestaurants();

        foreach ($restaurants as $restaurant) {
            $this->RestaurantRepository->updateOrCreate(
                [
                    'source_id' => $restaurant->source_id
                ],
                [
                    'source_id' => $restaurant->source_id,
                    'latitude'  => $restaurant->latitude,
                    'longitude' => $restaurant->longitude,
                ]
            );
        }
    }   
}