<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.    
     * @var array<string>
     */
    protected $fillable = ['source_id', 'latitude', 'longitude'];
}
