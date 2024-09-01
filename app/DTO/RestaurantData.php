<?php

namespace App\DTO;

/**
 * Data Transfer Object (DTO) for a restaurant.
 */
class RestaurantData
{

    public int|string $source_id;        
    public float $latitude;
    public float $longitude;

    /**
     * Create a new instance of the RestaurantData class.     
     *
     * @param int|string $osm_id source id of the restaurant.     
     * @param float $latitude The latitude coordinate of the restaurant's location.
     * @param float $longitude The longitude coordinate of the restaurant's location.
     * 
     * @return void
     */
    public function __construct($source_id, $latitude, $longitude)
    {
        $this->source_id = $source_id;        
        $this->latitude  = $latitude;
        $this->longitude = $longitude;
    }
}