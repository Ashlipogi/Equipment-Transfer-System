<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferredItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'transfer_to',
        'name_designation',
        'designated_office',
        'designated_office_name',
        'position_intended_transfer',
        'position_intended_office',
        'transferred_at'
    ];

    protected $casts = [
        'transferred_at' => 'datetime'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
