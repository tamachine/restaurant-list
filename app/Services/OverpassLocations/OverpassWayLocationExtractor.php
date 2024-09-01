<?php

namespace App\Services\OverpassLocations;

use App\Interfaces\OverpassLocationExtractorInterface;

/**
 * Extractor for Overpass Way location data.
 */
class OverpassWayLocationExtractor extends OverpassLocationExractor implements OverpassLocationExtractorInterface
{
    /**
     * Set the coordinates based on the geometry of the way.
     *     
     * @param array $element An associative array containing 'geometry' with 'lat' and 'lon' keys for each point.
     * 
     * @return void
     */
    public function setCoordinates(array $element)
    {
        $geometry = $element['geometry'] ?? [];
        
        if (empty($geometry)) return;
        
        $latitudes  = array_column($geometry, 'lat');
        $longitudes = array_column($geometry, 'lon');
        
        $this->latitude  = array_sum($latitudes)  / count($latitudes);
        $this->longitude = array_sum($longitudes) / count($longitudes);       
    }

}
