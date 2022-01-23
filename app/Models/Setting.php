<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['company_name', 'company_phone_no', 'company_email', 'company_address', 'company_logo', 'invoice_prefix', 'invoice_theme_color', 'termsnconditions', 'currency', 'card_price'];
}
