<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artwork;

class ArtworksController extends Controller
{
    public function index(){
    	$artworks = Artwork::all();
    	return view('welcome')->with('artworks', $artworks);
    }

    public function create(){
    	return view('artworks.create');
    }

    public function store(Request $request){
    	$this->validate($request, [
    		'title' => 'required',
            'thumbnail_dir' => 'image|nullable|max:1999',
            'price' => 'required'
    	]);

        // Handle file upload
        if ($request->hasFile('thumbnail_dir')) {
            # Get the file name with the extension.
            $fileNameWithExt = $request->file('thumbnail_dir')->getClientOriginalName();

            # Get just the file name.
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            # Get just the filename extension.
            $extension = $request->file('thumbnail_dir')->getClientOriginalExtension();

            # Filename to store
            $fileNametoStore = $fileName . '_' . time() . '.' . $extension;

            # Upload the image
            $path = $request->file('thumbnail_dir')->storeAs('public/photos/', $fileNametoStore);
        } else {
            $fileNametoStore = 'noImage.jpg';
        }

        // $picPath = (new ArtworkThumbnailController)->update($request);

        // $picPath::update();

        //$path = $request->file('thumbnail_dir')->store('/photos/', $request->user()->id, 'public');

    	// $full_dir = "/photos/" . $request->input('thumbnail_dir');

    	$artwork = new Artwork;
    	$artwork->title = $request->input('title');
    	$artwork->artwork_type = $request->input('artwork_type');
    	$artwork->user_id = auth()->user()->id;
    	$artwork->artwork_price = $request->input('price');
    	$artwork->artwork_thumbnail = $fileNametoStore;
        $artwork->save();

    	return redirect('/');
    }

    public function update(Request $request, $id){
    	$this->validate($request, [
    		'title' => 'required'
    	]);

    	$artwork = new Artwork;
    	$artwork->title = $request->input('title');
    	$artwork->artwork_type = $request->input('artwork_type');
    	$artwork->artwork_price = $request->input('price');
    	$artwork->artwork_thumbnail = $request->input('thumbnail_dir');

    	return redirect('/');
    }
}
