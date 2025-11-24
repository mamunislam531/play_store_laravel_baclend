<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavAuthorQuote extends Model
{
    protected $fillable = [
        'device_id',
        'quote_id',
    ];

    public function quote()
    {
        return $this->belongsTo(\App\Models\AuthorQuote::class, 'quote_id');
    }
}
