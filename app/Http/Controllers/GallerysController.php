<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\gallerys;
use App\Http\Requests\GalleryRequest;

class GallerysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pagination = 5;
        $datas   = gallerys::orderBy('created_at', 'desc')->paginate($pagination);
    
        $datas = gallerys::all();
        return view('gallery.list', compact(
            'datas'
        ))->with('i', ($request->input('page', 1) - 1) * $pagination);;
        $data['gallery'] = gallerys::paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GalleryRequest $request)
    {
        $imageNameHash = null;

        if($request->hasFile('image')) {
            $image = $request->image;
            $imageNameHash = $image->hashName();
            $image->move(public_path('/uploads/gallery/'), $imageNameHash);
        }

        $gallerys = new gallerys();
        $gallerys->image = $imageNameHash;
        $gallerys->title = $request->title;
    
        $gallerys->save();

        return redirect('admin/gallerys');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['gallery'] = gallerys::find($id);

        return view('gallery.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['gallery'] = gallerys::find($id);

        return view('gallery.edit', $data);
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
        $imageNameHash = null;

        if($request->hasFile('image')) {
            $image = $request->image;
            $imageNameHash = $image->hashName();
            $image->move(public_path('/uploads/gallery'), $imageNameHash);
        }

        $gallerys = gallerys::find($id);
        $gallerys->image = $imageNameHash ?? $gallerys->image;
        $gallerys->title = $request->title ?? $$gallerys->title;
      
        $gallerys->save();

        return redirect('admin/gallerys');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        gallerys::find($id)->delete();

        return redirect('admin/gallerys');
    }
}
