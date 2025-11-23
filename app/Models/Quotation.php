<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'quote', 'author'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
