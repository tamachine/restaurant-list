<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Interfaces\RestaurantRepositoryInterface;
use App\Jobs\UpdateRestaurantListJob;
use App\Services\RestaurantService;
use Illuminate\Support\Facades\Queue;
use Mockery;
use PHPUnit\Framework\Attributes\Test;

class RestaurantControllerTest extends TestCase
{    

    protected $restaurantData = [
        'source_id' => '123',
        'latitude'  => '45.0',
        'longitude' => '-93.0'
    ];

    protected function tearDown(): void
    {        
        Mockery::close();
        parent::tearDown();
    }

    #[Test]
    public function it_returns_a_list_of_restaurants()
    {       
        $mockRepository = Mockery::mock(RestaurantRepositoryInterface::class);
        $mockRepository->shouldReceive('getAll')
                       ->andReturn(collect([(object) $this->restaurantData]));

        $this->app->instance(RestaurantRepositoryInterface::class, $mockRepository);
        
        $response = $this->getJson('/');

        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [$this->restaurantData],
                 ]);
    }

    #[Test]
    public function it_dispatches_update_list_job()
    {        
        Queue::fake();

        $mockService = Mockery::mock(RestaurantService::class);
        
        $this->instance(RestaurantService::class, $mockService);

        $response = $this->post('/update-list');

        Queue::assertPushed(UpdateRestaurantListJob::class);
        
        $response->assertStatus(202)
                 ->assertJson(['message' => 'Update job dispatched successfully']);
    }

    #[Test]
    public function it_returns_restaurant_resource_when_found()
    {
        $id = $this->restaurantData['source_id'];
        
        $mockRepository = Mockery::mock(RestaurantRepositoryInterface::class);
        $mockRepository->shouldReceive('findById')
                       ->with($id)
                       ->andReturn((object) $this->restaurantData);
                
        $this->app->instance(RestaurantRepositoryInterface::class, $mockRepository);
        
        $response = $this->getJson("/get/{$id}");

        $response->assertStatus(200)
             ->assertJson([
                 'data' => $this->restaurantData,
             ]);
    }

    #[Test]
    public function it_returns_restaurant_resource_when_not_found()
    {
        $id = 'nonexistent_id';        
                
        $response = $this->getJson("/get/{$id}");

        $response->assertStatus(404);
    }
}
