<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardReceipt extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'tenant_id','receipt_status', 'issued_date', 'returned_date', 'card_id', 'card_price', 'currency', 'from_transaction'];

    // Relationship With Card
    public function card() {
        return $this->belongsTo(Card::class);
    }

    // Relationship With Tenant
    public function tenant() {
        return $this->belongsTo(Tenant::class);
    }
}
