<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    protected $table = "tags";
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'taggable');
    }
}
