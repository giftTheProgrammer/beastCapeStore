<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Artwork;
use App\Models\ArtistProfile;
use App\Http\Controllers\Auth;

class ArtworksController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function viewArtist($id){
        $myworks = Artwork::where('artist_id', $id)->get();
        return view('artworks.catalogue')->with('myworks', $myworks);
    }

    /**
    * Display a listing of the resource.
    *
    *
    */

    public function index(){
    	$artworks = Artwork::all();
    	return view('welcome')->with('artworks', $artworks);
    }

    public function create($id){
        $artist = ArtistProfile::find($id);
        // $this->authorize('create', Artworks::class);
    	return view('artworks.create')->with('artist', $artist);
    }

    public function store(Request $request){
    	$this->validate($request, [
    		'title' => 'required',
            'artist' => 'required',
            'thumbnail_dir' => 'image|nullable|max:1999',
            'price' => 'required',
            'audiofile_dir' => 'required|file|mimes:audio/mpeg,mpga,mp3,wav,aac'
    	]);

        // Handle image file upload
        if ($request->hasFile('thumbnail_dir')) {
            # Get the file name with the extension.
            $fileNameWithExt = $request->file('thumbnail_dir')->getClientOriginalName();

            # Get just the file name.
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            # Get just the filename extension.
            $extension = $request->file('thumbnail_dir')->getClientOriginalExtension();

            # Filename to store.
            $fileNametoStore = $fileName . '_' . time() . '.' . $extension;

            # Upload the image.
            $path = $request->file('thumbnail_dir')->storeAs('public/photos/', $fileNametoStore);
        } else {
            $fileNametoStore = 'no_image_available.jpg';
        }

        // Handle audio file upload
        if ($request->hasFile('audiofile_dir')) {
            # Get the file name with the extension.
            $wholeFileName = $request->file('audiofile_dir')->getClientOriginalName();

            # Get the size of the audio file.
            $audioFileSize = $request->file('audiofile_dir')->getSize();

            # Get just the file name.
            $songName = pathinfo($wholeFileName, PATHINFO_FILENAME);

            # Get just the filename extension.
            $extension = $request->file('audiofile_dir')->getClientOriginalExtension();

            # Filename to store.
            $songNameToStore = $songName . '_' . time() . '.' . $extension;

            # Upload the song
            $songPath = $request->file('audiofile_dir')->storeAs('public/songs/', $songNameToStore);
        }

    	$artwork = new Artwork;
    	$artwork->title = $request->input('title');
        // $artwork->artist = $request->input('artist');
        $artwork->description = $request->input('description');
    	$artwork->artwork_type = $request->input('artwork_type');
    	$artwork->artist_id = $request->input('artist_id');
    	$artwork->artwork_price = $request->input('price');
    	$artwork->artwork_thumbnail = $fileNametoStore;
        $artwork->mainfile = $songNameToStore;
        $artwork->save();

    	return redirect('/artworks/viewArtist/'.$request->input('artist_id'))->with('success', 'Song successfully submitted!');
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
        if (auth()->user()->id !== $artwork->user_id) {
            return redirect('/')->with('error', 'Unauthorized page!');
        }

        return view('artworks.edit')->with('artwork', $artwork);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param Illuminate\Http\Request $request
    * @param int $id
    * @return Illuminate\Http\Response.
    */
    public function update(Request $request, $id){
    	$this->validate($request, [
    		'title' => 'required',
            'artist' => 'required',
            'thumbnail_dir' => 'image|nullable|max:1999',
            'price' => 'required',
            'audiofile_dir' => 'nullable|file|mimes:audio/mpeg,mpga,mp3,wav,aac'
    	]);

        // Handle image file upload
        if ($request->hasFile('thumbnail_dir')) {
            # Get the file name with the extension.
            $fileNameWithExt = $request->file('thumbnail_dir')->getClientOriginalName();

            # Get just the file name.
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            # Get just the filename extension.
            $extension = $request->file('thumbnail_dir')->getClientOriginalExtension();

            # Filename to store.
            $fileNametoStore = $fileName . '_' . time() . '.' . $extension;

            # Upload the image.
            $path = $request->file('thumbnail_dir')->storeAs('public/photos/', $fileNametoStore);
        }

        // Handle audio file upload
        if ($request->hasFile('audiofile_dir')) {
            # Get the file name with the extension.
            $wholeFileName = $request->file('audiofile_dir')->getClientOriginalName();

            # Get the size of the audio file.
            $audioFileSize = $request->file('audiofile_dir')->getSize();

            # Get just the file name.
            $songName = pathinfo($wholeFileName, PATHINFO_FILENAME);

            # Get just the filename extension.
            $extension = $request->file('audiofile_dir')->getClientOriginalExtension();

            # Filename to store.
            $songNameToStore = $songName . '_' . time() . '.' . $extension;

            # Upload the song
            $songPath = $request->file('audiofile_dir')->storeAs('public/songs/', $songNameToStore);
        }

    	$artwork = Artwork::find($id);
    	$artwork->title = $request->input('title');
        $artwork->description = $request->input('description');
        $artwork->artist = $request->input('artist');
    	$artwork->artwork_type = $request->input('artwork_type');
    	$artwork->artwork_price = $request->input('price');
        if ($request->hasFile('thumbnail_dir')) {
            $artwork->artwork_thumbnail = $fileNametoStore;
        }
        if ($request->hasFile('audiofile_dir')) {
            $artwork->mainfile = $songNameToStore;
        }
    	$artwork->save();

    	return redirect('/home')->with('success', 'Song Updated!');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param int $id
    * @return Illumintate\Http\Response
    */
    public function destroy($id){
        $artwork = Artwork::find($id);

        // Check for correct user
        if (auth()->user()->id !== $artwork->user_id) {
            return redirect('/')->with('error', 'Unauthorized page!');
        }

        // Delete cover image
        Storage::delete('/public/photos/'.$artwork->artwork_thumbnail);

        // Delete artwork
        Storage::delete('/public/songs/'.$artwork->mainfile);

        $artwork->delete();
        return redirect('user/artworks')->with('success', 'Song Removed!');
    }
}
