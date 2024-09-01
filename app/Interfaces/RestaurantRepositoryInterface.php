<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

/**
 * Interface for interacting with restaurant data storage.
 *
 */
interface RestaurantRepositoryInterface
{
    public function getAll(): Collection;
    public function findById($sourceId);
    public function updateOrCreate(array $attributes, array $values);
}