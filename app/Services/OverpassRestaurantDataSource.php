<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use App\DTO\RestaurantData;
use App\Interfaces\RestaurantDataSourceInterface;
use App\Services\OverpassLocations\OverpassLocationExtractorFactory;

/**
 * Retrieves restaurant data from the Overpass API.
 */
class OverpassRestaurantDataSource implements RestaurantDataSourceInterface
{
    protected string $url;
    protected array $headers;
    protected array $data;

    protected OverpassLocationExtractorFactory $extractors;

    public function __construct()
    {
        $this->url      = $this->getUrl();
        $this->headers  = $this->getHeaders();
        $this->data     = $this->getRequestData();        
    }

     /**
     * Get a collection of restaurants from the Overpass API.
     *
     * @return Collection|RestaurantData[] 
     */
    public function getRestaurants(): Collection
    {
        $response = Http::asForm()->withHeaders($this->headers)->post(
            $this->url,
            $this->data
        );

        $restaurants = $response->json()['elements'];
                
        return collect($restaurants)->map(function ($element) {
            $type = $element['type'];
            
            $extractor = OverpassLocationExtractorFactory::createExtractor($type);            

            $extractor->setCoordinates($element);

            return new RestaurantData(
                $element['id'],                
                $extractor->getLatitude(),
                $extractor->getLongitude()
            );
        })->filter(); 
    }

     /**
     * Get the URL of the Overpass API endpoint.
     *
     * @return string 
     */
    protected function getUrl(): string
    {
        return 'https://overpass-api.de/api/interpreter';
    }

    /**
     * Get the headers to be used in the HTTP request.
     *
     * @return array 
     */
    protected function getHeaders(): array
    {
        return [
            'User-Agent'    => 'Mi servicio',
            'Content-Type'  => 'application/x-www-form-urlencoded; charset=UTF-8',
        ];
    }

    /**
     * Get the data to be sent in the HTTP request.
     *
     * @return array 
     */
    protected function getRequestData(): array
    {
        return [
            'data' => '[out:json][timeout:25];area(id:3600349053)->.searchArea;nwr["amenity"="fast_food"]["name"="McDonald\'s"](area.searchArea);out geom;',
        ];
    }
}