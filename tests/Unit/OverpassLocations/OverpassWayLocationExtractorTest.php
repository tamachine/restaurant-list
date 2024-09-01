<?php

namespace Tests\Unit;

use App\Services\OverpassLocations\OverpassWayLocationExtractor;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class OverpassWayLocationExtractorTest extends TestCase
{
    #[Test]
    public function it_set_coordinates()
    {
        $extractor = new OverpassWayLocationExtractor();
        
        $element = [
            'geometry' => [
                ['lat' => 45.0, 'lon' => -93.0],
                ['lat' => 46.0, 'lon' => -94.0],
            ],
        ];
        $extractor->setCoordinates($element);
        
        $this->assertEquals(45.5, $extractor->getLatitude());
        $this->assertEquals(-93.5, $extractor->getLongitude());
    }
    
    #[Test]
    public function it_set_coordinates_returns_null_when_no_geometry()
    {
        $extractor = new OverpassWayLocationExtractor();
        
        $element = ['geometry' => []];
        $extractor->setCoordinates($element);
        
        $this->assertNull($extractor->getLatitude());
        $this->assertNull($extractor->getLongitude());
    }
}

