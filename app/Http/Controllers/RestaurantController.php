<?php

namespace App\Http\Controllers;

use App\Http\Resources\RestaurantCollection;
use App\Http\Resources\RestaurantResource;
use App\Interfaces\RestaurantRepositoryInterface;
use App\Jobs\UpdateRestaurantListJob;
use App\Services\RestaurantService;

/**
 * Controller for handling restaurant-related operations.
 */
class RestaurantController extends Controller
{

    protected RestaurantRepositoryInterface $RestaurantRepository;    
    protected RestaurantService $restaurantService;
    
    /**
     * Create a new controller instance.
     *
     * @param RestaurantRepositoryInterface $RestaurantRepository The repository for restaurant data.
     * @param RestaurantService $restaurantService The service for restaurant operations.
     */
    public function __construct(RestaurantRepositoryInterface $RestaurantRepository, RestaurantService $restaurantService)
    {
        $this->RestaurantRepository = $RestaurantRepository;
        $this->restaurantService    = $restaurantService;
    }

    /**
     * Display a listing of the restaurants.          
     *
     * @return RestaurantCollection The collection of restaurants.
     */
    public function index()
    {
        $restaurants = $this->RestaurantRepository->getAll();

        return new RestaurantCollection($restaurants);
    }

    /**
     * Dispatch a job to update the restaurant list.
     *
     * @return \Illuminate\Http\JsonResponse JSON response indicating the job has been dispatched.
     */
    public function updateList()
    {
        dispatch(new UpdateRestaurantListJob($this->restaurantService));

        return response()->json(['message' => 'Update job dispatched successfully'], 202);
    }

     /**
     * Display the specified restaurant.     
     *
     * @param int|string $id The restaurant source id.
     * 
     * @return RestaurantResource|\Illuminate\Http\JsonResponse The restaurant resource or an error response.
     */
    public function show($id)
    {
        $restaurant = $this->RestaurantRepository->findById($id);

        if(!$restaurant) return response()->json(['error' => 'Restaurant not found'], 404);
        
        return new RestaurantResource($restaurant);        
    }
}
