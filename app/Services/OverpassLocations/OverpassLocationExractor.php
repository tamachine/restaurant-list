<?php

namespace App\Services\OverpassLocations;

abstract class OverpassLocationExractor 
{

    protected float|null $latitude  = null;
    protected float|null $longitude = null;

    /**
     * Get the latitude of the node.          
     *
     * @return float The latitude of the node.
     */
    public function getLatitude() : float|null
    {
        return $this->latitude;
    }

    /**
     * Get the longitude of the node.          
     *
     * @return float The longitude of the node.
     */
    public function getLongitude() : float|null
    {
        return $this->longitude;
    }
}