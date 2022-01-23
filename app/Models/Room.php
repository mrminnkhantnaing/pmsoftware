<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'r_number', 'building_id', 'floor_id'];

    // Relationship With Building
    public function building() {
        return $this->belongsTo(Building::class);
    }

    // Relationship With Floor
    public function floor() {
        return $this->belongsTo(Floor::class);
    }

    // Relationship With Partitions
    public function partitions() {
        return $this->hasMany(Partition::class);
    }

    // Relationship With Bedspaces
    public function bedspaces() {
        return $this->hasMany(Bedspace::class);
    }
}
