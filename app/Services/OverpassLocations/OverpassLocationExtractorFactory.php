<?php

namespace App\Services\OverpassLocations;

use App\Interfaces\OverpassLocationExtractorInterface;

/**
 * Factory class for creating instances of Overpass location extractors depending on the type element.
 */
class OverpassLocationExtractorFactory
{
    /**
     * Create an instance of an Overpass location extractor based on the specified type.     
     *
     * @param string $type The type of Overpass location extractor to create. Supported values are 'node', 'way', and 'relation'.
     * 
     * @return OverpassLocationExtractorInterface An instance of the appropriate Overpass location extractor.
     * 
     * @throws \InvalidArgumentException If the provided type is not recognized.
     */
    public static function createExtractor(string $type): OverpassLocationExtractorInterface
    {
        switch ($type) {
            case 'node':
                return new OverpassNodeLocationExtractor();
            case 'way':
                return new OverpassWayLocationExtractor();
            case 'relation':
                return new OverpassRelationLocationExtractor();
            default:
                throw new \InvalidArgumentException("unknown overpass type element: $type");
        }
    }
}
