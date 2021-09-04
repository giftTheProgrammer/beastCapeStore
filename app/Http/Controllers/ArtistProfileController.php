<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArtistProfile;
use Illuminate\Support\Facades\Auth;

class ArtistProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('artists.index')->with('artists', $user->artistprofile);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', ArtistProfile::class);
        return view('artists.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required', 'artform' => 'required','profile_pic' => 'image|nullable|max:1999',
        ]);

        // Handle image file upload
        if ($request->hasFile('profile_pic')) {
            # Get the file name with the extension.
            $fileNameWithExt = $request->file('profile_pic')->getClientOriginalName();

            # Get just the file name.
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            # Get just the filename extension.
            $extension = $request->file('profile_pic')->getClientOriginalExtension();

            # Filename to store.
            $fileNametoStore = $fileName . '_' . time() . '.' . $extension;

            # Upload the image.
            $path = $request->file('profile_pic')->storeAs('public/photos/profiles', $fileNametoStore);
        } else {
            $fileNametoStore = 'no_image_available.jpg';
        }

        $artist = new ArtistProfile;
        $artist->name = $request->input('name');
        $artist->moniker = $request->input('moniker');
        $artist->artform = $request->input('artform');
        $artist->profile_pic = $fileNametoStore;
        $artist->short_bio = $request->input('short_bio');
        $artist->fbhandle = $request->input('fbhandle');
        $artist->instahandle = $request->input('instahandle');
        $artist->twitterhandle = $request->input('twitterhandle');
        $artist->linkedinhandle = $request->input('linkedinhandle');
        $artist->pinhandle = $request->input('pinhandle');
        $artist->tthandle = $request->input('tthandle');
        $artist->user_id = auth()->user()->id;
        $artist->save();

        return redirect('/artists')->with('success','Profile saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $artist = ArtistProfile::find($id);
        return view('artists.show')->with('artist', $artist);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
