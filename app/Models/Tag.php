<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = "tags";
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name',
    ];
}
