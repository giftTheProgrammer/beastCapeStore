<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use App\Models\Artwork;
use App\Models\Manager;
use Illuminate\Support\Facades\Auth;
use DB;



class ManagersController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
    	$this->authorize('index', Manager::class);
    	// $artworks = Artwork::all();
        $artworks = DB::table('artworks')->join('artist_profiles', 'artist_id','=','artist_profiles.id')
        ->select('artworks.*', 'artist_profiles.moniker')->get();
    	return view('managers.index')->with('artworks', $artworks);
    }

    /**
    * Display the specified resource.
    *
    * @param int $id
    * @return Illuminate\Http\Response
    */
    public function show($id){
        $artwork = Artwork::find($id);
        return view('artworks.show')->with('artwork', $artwork);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param int $id
    * @return Illuminate\Http\Response.
    */
    public function edit($id){
        $artwork = Artwork::find($id);

        // Check for correct user
        if ($this->authorize('setStatus', Manager::class)) {
            return view('managers.edit')->with('artwork', $artwork);
        }
        return redirect('/')->with('error', 'Unauthorized page!');
    }

    
}
