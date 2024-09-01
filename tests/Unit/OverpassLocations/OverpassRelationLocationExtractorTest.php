<?php

namespace Tests\Unit;

use App\Services\OverpassLocations\OverpassRelationLocationExtractor;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class OverpassRelationLocationExtractorTest extends TestCase
{
    #[Test]
    public function it_set_coordinates()
    {
        $extractor = new OverpassRelationLocationExtractor();
        
        $element = [
            'bounds' => [
                'minlat' => 44.0,
                'maxlat' => 46.0,
                'minlon' => -94.0,
                'maxlon' => -92.0,
            ],
        ];
        $extractor->setCoordinates($element);
        
        $this->assertEquals(45.0, $extractor->getLatitude());
        $this->assertEquals(-93.0, $extractor->getLongitude());
    }
    
    #[Test]
    public function it_set_coordinates_returns_null_when_no_bounds()
    {
        $extractor = new OverpassRelationLocationExtractor();
        
        $element = ['bounds' => []];
        $extractor->setCoordinates($element);
        
        $this->assertNull($extractor->getLatitude());
        $this->assertNull($extractor->getLongitude());
    }
}
