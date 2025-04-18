<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
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
        return view('news.list', compact(
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
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsRequest $request)
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

        return redirect('admin/news');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return News::all();
        $data['news'] = News::find($id);

        return view('news.show', $data);
        // return view('news.show');

       
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

        return view('news.edit', $data);
        

        
        
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

        return redirect('admin/news');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        News::find($id)->delete();

        return redirect('admin/news');
    }
}
