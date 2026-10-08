<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'name',
        'code',
        'price',
        'stock',
        'description',
        'note',
        'is_active',
        'category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class); // satu product dimiliki oleh satu kategori, perhatikan nama fungsi tidak jamak
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
