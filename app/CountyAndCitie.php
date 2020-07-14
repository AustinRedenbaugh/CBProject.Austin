<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountyAndCitie extends Model
{
    // Table name
    protected $table = 'county_and_cities';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;
}
