<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteQuotation extends Model
{
    use HasFactory;

    protected $fillable = ['device_id', 'quotation_id'];

    public function quotation() {
        return $this->belongsTo(Quotation::class);
    }
}
