<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disaster extends Model
{
    use HasFactory;

    public $fillable = [
        'name', 'region', 'city', 'description', 'datetime', 'status', 'type'
    ];
}
