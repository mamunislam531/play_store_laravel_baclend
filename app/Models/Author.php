<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bio',
        'image',
    ];

    // Relationship: An author has many quotes
    public function quotes()
    {
        return $this->hasMany(AuthorQuote::class);
    }
}
