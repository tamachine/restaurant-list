<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

/**
 * Interface for accessing restaurant data sources.
 */
interface RestaurantDataSourceInterface
{
    /**
     * Retrieve a list of restaurants.
     *
     * @return Collection|RestaurantData[] 
     */
    public function getRestaurants(): Collection;
}