<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Requests\AddGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageNumber = $request->query('page_number', 0);
        $galleries = Gallery::with('comments','images', 'user')->skip($pageNumber*10)->take(10)->get();
        return response()->json($galleries);
    }


    public function myGalleries(Request $request)
    {
        $pageNumber = $request->query('page_number', 0);
        $userId= Auth::id();
        $galleries = Gallery::with('comments','images', 'user')->where('user_id',$userId)->skip($pageNumber*10)->take(10)->get();

        return response()->json($galleries);
    }


    public function authorsGalleries(Request $request)
    {
        $pageNumber = $request->query('page_number', 0);
        $userId= $request->query('author_id');
        $galleries = Gallery::with('comments','images', 'user')->find($userId)->skip($pageNumber*10)->take(10)->get();

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
         
       $gallery = Auth::user()->galleries()->create($data);

    //    createMany
       foreach ($request->images_url as $imageUrl) {
        $gallery->images()->create(['image_url' => $imageUrl]);
      }

      return response()->json($gallery);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {   
        $gallery->load('user', 'images');
        // $data= Gallery::with('user','images')->where('id',$gallery->id)->first();
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
