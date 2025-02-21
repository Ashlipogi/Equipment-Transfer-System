<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $fillable = [
        'transfer_id',
        'qty',
        'description',
        'date_purchase',
        'property_no',
        'classification_no',
        'unit',
        'total_value',
    ];

    protected $casts = [
        'date_purchase' => 'date',
        'total_value' => 'decimal:2',
    ];

    public function transfer()
    {
        return $this->belongsTo(Transfer::class);
    }

    // Add this new relationship
    public function transferredItem()
    {
        return $this->hasOne(TransferredItem::class);
    }
}
