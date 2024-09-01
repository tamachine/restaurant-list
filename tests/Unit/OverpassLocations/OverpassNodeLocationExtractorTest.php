<?php

namespace Tests\Unit;

use App\Services\OverpassLocations\OverpassNodeLocationExtractor;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class OverpassNodeLocationExtractorTest extends TestCase
{

    #[Test]
    public function it_set_coordinates()
    {
        $extractor = new OverpassNodeLocationExtractor();
        
        $element = ['lat' => 45.0, 'lon' => -93.0];
        $extractor->setCoordinates($element);
        
        $this->assertEquals(45.0, $extractor->getLatitude());
        $this->assertEquals(-93.0, $extractor->getLongitude());
    }
  
    #[Test]
    public function it_set_coordinates_returns_null_when_no_lat_or_lon()
    {
        $extractor = new OverpassNodeLocationExtractor();
                
        $elementWithoutLat = ['lon' => -93.0];
        $extractor->setCoordinates($elementWithoutLat);
        
        $this->assertNull($extractor->getLatitude());
        $this->assertEquals(-93.0, $extractor->getLongitude());
        
        $elementWithoutLon = ['lat' => 45.0];
        $extractor->setCoordinates($elementWithoutLon);
        
        $this->assertEquals(45.0, $extractor->getLatitude());
        $this->assertNull($extractor->getLongitude());

        $elementMissingBoth = [];
        $extractor->setCoordinates($elementMissingBoth);

        $this->assertNull($extractor->getLatitude());
        $this->assertNull($extractor->getLongitude());
    }
}

