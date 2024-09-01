<?php

namespace App\Repositories;

use App\Models\Restaurant;
use Illuminate\Support\Collection;
use App\Interfaces\RestaurantRepositoryInterface;

/**
 * Repository for managing restaurant data from database using eloquent.
 */
class RestaurantRepository implements RestaurantRepositoryInterface
{
    /**
     * Retrieve all restaurant records.    
     *
     * @return Collection A collection of `Restaurant` models.
     */
    public function getAll(): Collection
    {
        return Restaurant::all();
    }

    /**
     * Find a restaurant by its source ID. 
     *
     * @param mixed $source_id The source ID of the restaurant to find.
     * 
     * @return Restaurant|null The `Restaurant` model if found, otherwise `null`.
     */
    public function findById($sourceId)
    {
        return Restaurant::where('source_id', $sourceId)->first();
    }

    /**
     * Update an existing restaurant record or create a new one.
     *
     * @param array $attributes An associative array containing the attributes for updateOrCreate.
     * @param array $data An associative array containing the values for updateOrCreate.
     * 
     * @return Restaurant The updated or newly created `Restaurant` model.
     */
    public function updateOrCreate(array $attributes, array $values)
    {
        return Restaurant::updateOrCreate($attributes, $values);
    }
}