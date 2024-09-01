<?php

namespace App\Interfaces;

/**
 * Interface for extracting location data from Overpass API responses.
 *
 */
interface OverpassLocationExtractorInterface
{
    public function setCoordinates(array $element);
    public function getLatitude(): float|null;
    public function getLongitude(): float|null;
}