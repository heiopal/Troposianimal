<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pagination = 5;
        $datas   = News::orderBy('created_at', 'desc')->paginate($pagination);
    
        $datas = News::all();
        return view('berita', compact(
            'datas'
        ))->with('i', ($request->input('page', 1) - 1) * $pagination);;
        $data['news'] = News::paginate(10);

       
    
    



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $imageNameHash = null;

        if($request->hasFile('image')) {
            $image = $request->image;
            $imageNameHash = $image->hashName();
            $image->move(public_path('/uploads/news/'), $imageNameHash);
        }

        $news = new News;
        $news->image = $imageNameHash;
        $news->title = $request->title;
        $news->content = $request->content;
        $news->save();

        return redirect('/tentang');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['news'] = News::find($id);

        return view('postberita', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['news'] = News::find($id);
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
            $image->move(public_path('/uploads/news/'), $imageNameHash);
        }

        $news = News::find($id);
        $news->image = $imageNameHash ?? $news->image;
        $news->title = $request->title ?? $news->title;
        $news->content = $request->content ?? $news->content;
        $news->save();

        return redirect('/berita');
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
