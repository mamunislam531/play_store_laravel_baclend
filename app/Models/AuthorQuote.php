<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthorQuote extends Model
{
    protected $fillable = [
        'author_id',
        'quote',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
