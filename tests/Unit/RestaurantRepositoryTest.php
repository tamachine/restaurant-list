<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Restaurant;
use App\Repositories\RestaurantRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;

class RestaurantRepositoryTest extends TestCase
{
    use RefreshDatabase; 

    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new RestaurantRepository();
    }

    #[Test]
    public function it_returns_a_collection_of_restaurants_when_get_all()
    {
        $restaurant = Restaurant::factory()->create(); 

        $result = $this->repository->getAll();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertTrue($result->contains($restaurant));
    }

    #[Test]
    public function it_returns_a_restaurant_when_found_by_id()
    {
        Restaurant::factory()->create(['source_id' => '123']);

        $result = $this->repository->findById('123');

        $this->assertNotNull($result);
        $this->assertInstanceOf(Restaurant::class, $result);
        $this->assertEquals('123', $result->source_id);
    }

    #[Test]
    public function it_returns_null_when_not_found_by_id()
    {
        $result = $this->repository->findById('nonexistent_id');

        $this->assertNull($result);
    }

    #[Test]
    public function it_updates_an_existing_restaurant_when_using_update_or_create()
    {
        Restaurant::factory()->create(['source_id' => '123']);

        $updatedRestaurant = $this->repository->updateOrCreate(
            ['source_id' => '123'],
            ['latitude' => '50.0', 'longitude' => '-90.0']
        );

        $this->assertEquals('50.0', $updatedRestaurant->latitude);
        $this->assertEquals('-90.0', $updatedRestaurant->longitude);
    }

    #[Test]
    public function it_creates_a_new_restaurant_when_using_update_or_create()
    {
        $newRestaurant = $this->repository->updateOrCreate(
            ['source_id' => '456'],
            ['latitude' => '55.0', 'longitude' => '-85.0']
        );

        $this->assertNotNull($newRestaurant);
        $this->assertEquals('456', $newRestaurant->source_id);
        $this->assertEquals('55.0', $newRestaurant->latitude);
        $this->assertEquals('-85.0', $newRestaurant->longitude);
    }
}