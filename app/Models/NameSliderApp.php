<?php

// app/Models/NameSliderApp.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NameSliderApp extends Model
{
    protected $table = 'name_slider_app';

    protected $fillable = [
        'title',
        'image',
    ];
}
