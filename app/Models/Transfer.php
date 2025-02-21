<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $table = 'transfers';

    // Define the relationship with the Item model
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
