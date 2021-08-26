<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    use HasFactory;
    public function ArtistProfile(){
    	return $this->belongsTo('App\Models\ArtistProfile');
    }
}
