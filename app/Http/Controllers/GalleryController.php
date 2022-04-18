<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Requests\AddGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleries = Gallery::all();

        return response()->json($galleries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddGalleryRequest $request)
    {
        
        $data = $request->validated();
        $data['images_url'] = serialize($data['images_url']);
        
        $newGallery = Gallery::create($data);

        return response()->json($newGallery);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        $gallery['images_url'] = unserialize($gallery['images_url']);
        return response()->json($gallery);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGalleryRequest $request)
    {
        $data = $request->validated();
        $galleryToUpdate= Gallery::findOrFail($data['id']);
        $data['images_url'] = serialize($data['images_url']);
    
        $galleryToUpdate->title= $data['title'];
        $galleryToUpdate->description= $data['description'];
        $galleryToUpdate->images_url= $data['images_url'];
        $galleryToUpdate->save();

        return response()->json($galleryToUpdate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return response()->json($gallery);
    }
}
