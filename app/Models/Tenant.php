<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Tenant extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['id', 'name', 'idorpassport', 'whatsapp_no', 'phone_no', 'email', 'status', 'gender', 'country_id', 'joined_date', 'fixed_deposit', 'previous_balance'];

    // Relationship with Country
    public function country() {
        return $this->belongsTo(Country::class);
    }

    // Relationship with Transactions
    public function transactions() {
        return $this->hasMany(Transaction::class)->orderBy('created_at', 'desc');
    }

    // Get the last transaction
    public function transaction() {
        return $this->hasOne(Transaction::class)->latest();
    }

    // Relationship with Cards
    public function cards() {
        return $this->belongsToMany(Card::class, 'card_receipts', 'tenant_id', 'card_id');
    }

    // Relationship with Card Receipts
    public function card_receipts() {
        return $this->hasMany(CardReceipt::class);
    }

    // Relationship with Fixed Deposit
    public function fixed_deposit_model() {
        return $this->hasOne(FixedDeposit::class);
    }
}
