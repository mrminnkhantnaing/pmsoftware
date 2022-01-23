<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'slug', 'location', 'full_address'];

    // Relationship With Floors
    public function floors() {
        return $this->hasMany(Floor::class);
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
