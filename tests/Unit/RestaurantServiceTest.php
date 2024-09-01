<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use Illuminate\Support\Collection;
use App\Interfaces\RestaurantRepositoryInterface;
use App\Interfaces\RestaurantDataSourceInterface;
use App\Services\RestaurantService;
use App\Dto\RestaurantData; 
use PHPUnit\Framework\Attributes\Test;

class RestaurantServiceTest extends TestCase
{
    private $restaurantData;
    private $restaurantDataMapping;

    protected function setUp(): void
    {
        parent::setUp();
                
        $this->restaurantData = new Collection([
            new RestaurantData('123', '45.0', '-93.0'),
            new RestaurantData('456', '46.0', '-94.0')
        ]);
        
        $this->restaurantDataMapping = [
            '123' => new RestaurantData('123', '45.0', '-93.0'),
            '456' => new RestaurantData('456', '46.0', '-94.0')
        ];
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    #[Test]
    public function test_update_restaurant_list()
    {
        
        $repositoryMock = $this->createRepositoryMock();
        $dataSourceMock = $this->createDataSourceMock();
        
        $service = new RestaurantService($repositoryMock, $dataSourceMock);

        $service->updateRestaurantList();

        $this->verifyRepositoryMock($repositoryMock);
        $this->verifyUpdatedRestaurant($repositoryMock, '456');
    }

    private function createRepositoryMock()
    {
        $repositoryMock = Mockery::mock(RestaurantRepositoryInterface::class);

        foreach ($this->restaurantDataMapping as $sourceId => $data) {
            $repositoryMock->shouldReceive('updateOrCreate')
                           ->with(['source_id' => $sourceId], [
                               'source_id' => $sourceId,
                               'latitude'  => $data->latitude,
                               'longitude' => $data->longitude,
                           ])
                           ->once()
                           ->andReturn(true);
        }
        
        $repositoryMock->shouldReceive('findById')
                       ->with('456')
                       ->once()
                       ->andReturn($this->restaurantDataMapping['456']);

        return $repositoryMock;
    }

    private function createDataSourceMock()
    {
        $dataSourceMock = Mockery::mock(RestaurantDataSourceInterface::class);

        $dataSourceMock->shouldReceive('getRestaurants')
                       ->once()
                       ->andReturn($this->restaurantData);

        return $dataSourceMock;
    }

    private function verifyRepositoryMock($repositoryMock)
    {
        foreach ($this->restaurantDataMapping as $sourceId => $data) {
            $repositoryMock->shouldHaveReceived('updateOrCreate')
                           ->with(['source_id' => $sourceId], [
                               'source_id' => $sourceId,
                               'latitude'  => $data->latitude,
                               'longitude' => $data->longitude,
                           ])
                           ->once();
        }
    }

    private function verifyUpdatedRestaurant($repositoryMock, $sourceId)
    {
        $updatedRestaurant = $repositoryMock->findById($sourceId);

        $this->assertNotNull($updatedRestaurant);
        $this->assertEquals($sourceId, $updatedRestaurant->source_id);
        $this->assertEquals($this->restaurantDataMapping[$sourceId]->latitude, $updatedRestaurant->latitude);
        $this->assertEquals($this->restaurantDataMapping[$sourceId]->longitude, $updatedRestaurant->longitude);
    }
}