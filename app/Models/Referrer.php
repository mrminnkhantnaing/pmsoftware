<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referrer extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'idorpassport', 'whatsapp_no', 'phone_no', 'email', 'gender', 'country_id'];

    // Relationship with Country
    public function country() {
        return $this->belongsTo(Country::class);
    }

    // Relationship with Transactions
    public function transactions() {
        return $this->hasMany(Transaction::class)->orderBy('created_at', 'desc');
    }
}
