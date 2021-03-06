<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use App\Models\Artwork;
use App\Models\ArtistProfile;
use Illuminate\Support\Facades\Auth;
use DB;

class ArtworksController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'playerLoad', 'musicView', 'cart', 'addToCart', 'remove']]);
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
    	$artworks = Artwork::where('status', 'Approved')->get();
    	return view('welcome')->with('artworks', $artworks);
    }

    public function musicView(Request $request){
        $songs = DB::table('artworks')->join('artist_profiles', 'artist_id', '=', 'artist_profiles.id')
        ->select('artworks.*', 'artist_profiles.moniker')
        ->where([['title','!=',Null],
            [function ($query) use ($request){
                if (($term = $request->term)) {
                    $query->orWhere('title', 'LIKE', '%' . $term . '%')->get();
                }
            }],['status','Approved']])->get();


        $artworks = Artwork::where([
            ['title','!=',Null],
            [function ($query) use ($request){
                if (($term = $request->term)) {
                    $query->orWhere('title', 'LIKE', '%' . $term . '%')->get();
                }
            }]])->where('status', 'Approved')->where('artwork_type', 'music')->get();
        // return view('artworks.music', compact('artworks'))->with('i', ($request->input('page', 1) - 1) * 5);
        return view("artworks.music")->with("artworks", $songs);
    }

    public function create($id){
        $artist = ArtistProfile::find($id);
        if (Gate::allows('artform-create', Auth::user())) {
            
            return view('artworks.create')->with('artist', $artist);
        }
        abort(403);
        
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

    public function cart(){
        return view('trolley');
        // return session()->get('cart', []);
    }

    public function addToCart($id){
            $artwork = DB::table('artworks')->join('artist_profiles', 'artist_id', '=', 'artist_profiles.id')
            ->select('artworks.*', 'artist_profiles.moniker')->where('artworks.id', $id)->get();

            $cart = session()->get('cart', []);

            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
                session()->put('cart', $cart);
            } else {
                $cart[$id] = [
                    "name" => $artwork[0]->title,
                    "artist" => $artwork[0]->moniker,
                    "quantity" => 1,
                    "price" => $artwork[0]->artwork_price,
                    "image" => $artwork[0]->artwork_thumbnail
                ];
            }

            session()->put('cart', $cart);
            return $cart;
            return redirect()->back()->with('success', 'Artwork added to cart successfully');
    }

    public function updateCart(Request $request){
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully.');
        }
    }

    public function checkout(){
        return view('checkout');
    }

    public function remove(Request $request){
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Artwork removed successfully');
        }

    }


    public function playerLoad($id) {
        $artwork = Artwork::find($id);
        return $artwork;
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
        //$artwork->artist = $request->input('artist');
    	$artwork->artwork_type = $request->input('artwork_type');
    	$artwork->artwork_price = $request->input('price');
        if ($request->hasFile('thumbnail_dir')) {
            $artwork->artwork_thumbnail = $fileNametoStore;
        }
        if ($request->hasFile('audiofile_dir')) {
            $artwork->mainfile = $songNameToStore;
        }
    	$artwork->save();

    	return redirect('/artworks/viewArtist/'.$request->input('artist_id'))->with('success', 'Song Updated!');
    }

    /**
    * Update the specified resource in storage.
    *
    * @param Illuminate\Http\Request $request
    * @param int $id
    * @return Illuminate\Http\Response.
    */
    public function approve(Request $request, $id){

        $artwork = Artwork::find($id);
        $artwork->status = $request->input('status');
        
        $artwork->save();

        return redirect('/managers/'.$artwork->id.'/setStatus')->with('success', 'Status changed!');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param int $id
    * @return Illumintate\Http\Response
    */
    public function destroy($id){
        $artwork = Artwork::find($id);
        $artist = ArtistProfile::find($artwork->artist_id);

        // Check for correct user
        if (auth()->user()->id !== $artist->user_id) {
            return redirect('/')->with('error', 'Unauthorized page!');
        }

        // Delete cover image
        Storage::delete('/public/photos/'.$artwork->artwork_thumbnail);

        // Delete artwork
        Storage::delete('/public/songs/'.$artwork->mainfile);

        $artwork->delete();
        return redirect('/artworks/viewArtist/'.$artist->id)->with('success', 'Song Removed!');
    }
}
