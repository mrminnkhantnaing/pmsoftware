<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partition extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'p_number', 'status', 'building_id', 'floor_id', 'flat_id'];

    protected $with = ['transactions', 'transactions.tenant'];

    // Relationship With Building
    public function building() {
        return $this->belongsTo(Building::class);
    }

    // Relationship With Floor
    public function floor() {
        return $this->belongsTo(Floor::class);
    }

    // Relationship With Flat
    public function flat() {
        return $this->belongsTo(Flat::class);
    }

    // Relationship With Transactions
    public function transactions() {
        return $this->hasMany(Transaction::class)->latest();
    }
}
