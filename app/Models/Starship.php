<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Starship extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'model',
        'manufacturer',
        'cost_in_credits',
        'length',
        'max_atmosphering_speed',
        'crew',
        'passengers',
        'cargo_capacity',
        'consumables',
        'hyperdrive_rating',
        'mglt',
        'starship_class',
        'pilots',
        'films',
        'url',
        'created',
        'edited',
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function store()
    {
        return $this->create(request($this->getFillable()));
    }

    public function getById($id)
    {
        return $this->where('id', $id)->with('vehicles')->firstOrFail();
    }

}
