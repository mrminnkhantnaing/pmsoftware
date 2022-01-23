<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'building_id'];

    // Relationship With Building
    public function building() {
        return $this->belongsTo(Building::class);
    }

    // Relationship With Flats
    public function flats() {
        return $this->hasMany(Flat::class);
    }

    // Relationship With Partitions
    public function partitions() {
        return $this->hasMany(Partition::class);
    }
}
