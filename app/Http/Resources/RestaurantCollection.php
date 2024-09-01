<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * A collection of restaurant resources.
 */
class RestaurantCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.    
     *
     * @param Request $request The incoming HTTP request instance.
     * 
     * @return array<int|string, mixed> The transformed array representation of the resource collection.
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
