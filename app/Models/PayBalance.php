<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayBalance extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_id', 'invoice_status', 'no_of_tenant', 'card_id', 'start_date', 'end_date', 'price', 'card_price', 'currency', 'sub_total', 'total_price', 'initial_payment_amount', 'current_payment_amount', 'balance', 'building_id', 'floor_id', 'flat_id', 'partition_id', 'tenant_id', 'invoice_type'];

    // Relationship with Transaction / Invoice
    public function invoice() {
        return $this->belongsTo(Transaction::class);
    }

    // Relationship With Card
    public function card() {
        return $this->belongsTo(Card::class);
    }

    // Relationship with Building
    public function building() {
        return $this->belongsTo(Building::class);
    }

    // Relationship with Floor
    public function floor() {
        return $this->belongsTo(Floor::class);
    }

    // Relationship with Flat
    public function flat() {
        return $this->belongsTo(Flat::class);
    }

    // Relationship with Partition
    public function partition() {
        return $this->belongsTo(Partition::class);
    }

    // Relationship with Tenant
    public function tenant() {
        return $this->belongsTo(Tenant::class);
    }
}
