<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function productions()
    {
        return $this->hasMany(Production::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}
