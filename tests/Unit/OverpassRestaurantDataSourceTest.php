<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\OverpassRestaurantDataSource;
use App\DTO\RestaurantData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\Test;

class OverpassRestaurantDataSourceTest extends TestCase
{
    protected $overpassApiUrl = 'https://overpass-api.de/api/interpreter';    

    #[Test]
    public function it_returns_a_collection_of_restaurants()
    {
        $mockResponse = [
            'elements' => [
                [
                    'type' => 'node',
                    'id'   => '1',
                    'lat'  => '45.0',
                    'lon'  => '-93.0',
                ],
                [
                    'type' => 'node',
                    'id'   => '2',
                    'lat'  => '46.0',
                    'lon'  => '-94.0',
                ],
            ],
        ];
        
        Http::fake([
            $this->overpassApiUrl => Http::response($mockResponse, 200),
        ]);

        $dataSource = new OverpassRestaurantDataSource();
        
        $restaurants = $dataSource->getRestaurants();        

        $this->assertInstanceOf(Collection::class, $restaurants);
        $this->assertCount(2, $restaurants);

        $first = $restaurants->first();
        $this->assertInstanceOf(RestaurantData::class, $first);
        $this->assertEquals('1', $first->source_id);
        $this->assertEquals('45.0', $first->latitude);
        $this->assertEquals('-93.0', $first->longitude);
    }

    #[Test]
    public function it_sends_correct_http_request()
    {
        Http::fake([
            $this->overpassApiUrl => Http::response(['elements' => []], 200),
        ]);

        $dataSource = new OverpassRestaurantDataSource();
        $dataSource->getRestaurants();

        Http::assertSent(function ($request) {
            return $request->url() === $this->overpassApiUrl
                && $request->method() === 'POST'
                && $request->hasHeader('User-Agent', 'Mi servicio')
                && $request->hasHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8')
                && $request->data()['data'] === '[out:json][timeout:25];area(id:3600349053)->.searchArea;nwr["amenity"="fast_food"]["name"="McDonald\'s"](area.searchArea);out geom;';
        });
    }
}
