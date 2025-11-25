<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NamesList extends Model
{
    protected $table = 'names_list';

    protected $fillable = [
        'religion_id',
        'gender',
        'name_bn',
        'name_en',
        'bn_meaning',
    ];

    public function religion()
    {
        return $this->belongsTo(Religion::class, 'religion_id');
    }
}
