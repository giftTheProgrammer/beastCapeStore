<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistProfile extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'moniker', 'artform', 'genre', 'profile_pic',
    'short_bio', 'interests', 'fbhandle', 'Instahandle', 'twitterhandle',
    'linkedinhandle', 'pinhandle', 'tthandle'];

    public function user(){
    	return $this->belongsTo('App\Models\User');
    }

    public function artwork(){
    	return $this->belongsTo('App\Models\Artwork');
    }
}
