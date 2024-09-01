<?php

namespace App\Services\OverpassLocations;

use App\Interfaces\OverpassLocationExtractorInterface;

/**
 * Extractor for Overpass Relation location data.
 */
class OverpassRelationLocationExtractor extends OverpassLocationExractor implements OverpassLocationExtractorInterface
{

    /**
     * Set the coordinates based on the bounding box of the relation.
     *
     * @param array $element An associative array containing 'bounds' with 'minlat', 'maxlat', 'minlon', and 'maxlon' keys.
     * 
     * @return void
     */
    public function setCoordinates(array $element)
    {
        $bounds = $element['bounds'] ?? [];
        if (empty($bounds)) {
            return ['lat' => null, 'lon' => null];
        }
        
        $this->latitude  = ($bounds['minlat'] + $bounds['maxlat']) / 2;
        $this->longitude = ($bounds['minlon'] + $bounds['maxlon']) / 2;        
    }
}
