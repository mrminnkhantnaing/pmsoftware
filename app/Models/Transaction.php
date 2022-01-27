<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'invoice_no', 'invoice_prefix','invoice_status', 'tenant_id', 'building_id', 'floor_id', 'flat_id', 'partition_id', 'no_of_tenant', 'card_id', 'price','card_price', 'currency', 'start_date', 'end_date','sub_total', 'total_price', 'reservation_date', 'deposit', 'payment_amount', 'rest_payment_date', 'balance', 'referrer_id', 'invoice_type', 'notice', 'moved', 'paid_balance', 'fixed_deposit', 'previous_balance', 'created_another_invoice', 'reservation_activated'];

    // Relationship With Tenant
    public function tenant() {
        return $this->belongsTo(Tenant::class);
    }

    // Relationship With Referrer
    public function referrer() {
        return $this->belongsTo(Referrer::class);
    }

    // Relationship With PayBalance
    public function paybalances() {
        return $this->hasMany(PayBalance::class, 'invoice_id', 'id');
    }

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

    // Relationship With Partition
    public function partition() {
        return $this->belongsTo(Partition::class);
    }

    // Relationship With Card
    public function card() {
        return $this->belongsTo(Card::class);
    }
}
