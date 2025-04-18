<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AboutRequest;
use App\Models\About;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pagination = 5;
        $datas   = About::orderBy('created_at', 'desc')->paginate($pagination);
    
        $datas = about::all();
        return view('about.list', compact(
            'datas'
        ))->with('i', ($request->input('page', 1) - 1) * $pagination);;
        $data['about'] = About::paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('about.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AboutRequest $request)
    {
        $imageNameHash = null;

        if($request->hasFile('image')) {
            $image = $request->image;
            $imageNameHash = $image->hashName();
            $image->move(public_path('/uploads/abouts/'), $imageNameHash);
        }

        $about = new About();
        $about->image = $imageNameHash;
        $about->title = $request->title;
        $about->content = $request->content;
        $about->save();

        return redirect('admin/abouts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['about'] = About::find($id);

        return view('about.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['about'] = About::find($id);

        return view('about.edit', $data);
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
            $image->move(public_path('/uploads/abouts/'), $imageNameHash);
        }

        $about = About::find($id);
        $about->image = $imageNameHash ?? $about->image;
        $about->title = $request->title ?? $about->title;
        $about->content = $request->content ?? $about->content;
        $about->save();

        return redirect('admin/abouts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        About::find($id)->delete();

        return redirect('admin/abouts');
    }
}
