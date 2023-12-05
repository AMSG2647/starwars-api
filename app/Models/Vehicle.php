<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
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
        'vehicle_class',
        'pilots',
        'films',
        'url',
        'starship_id',
        'created',
        'edited',
    ];

    public function starships()
    {
        return $this->belongsTo(Starship::class, 'starship_id');
    }

    public function store()
    {
        return $this->create(request($this->getFillable()));
    }

    public function getById($id)
    {
        return $this->where('id', $id)->with('starships')->firstOrFail();
    }
}
