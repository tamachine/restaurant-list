<?php

namespace App\Services\OverpassLocations;

use App\Interfaces\OverpassLocationExtractorInterface;

/**
 * Extractor for Overpass Node location data.
 */
class OverpassNodeLocationExtractor extends OverpassLocationExractor implements OverpassLocationExtractorInterface 
{
    /**
     * Set the coordinates from an array of node data.       
     *
     * @param array $element An associative array containing 'lat' and 'lon' keys for latitude and longitude.
     * 
     * @return void
     */
    public function setCoordinates(array $element)
    {
        $this->latitude  = $element['lat'] ?? null;
        $this->longitude = $element['lon'] ?? null; 
    }  
}