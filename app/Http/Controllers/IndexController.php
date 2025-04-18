<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $pagination = 5;
        $datas   = News::orderBy('created_at', 'desc')->paginate($pagination);
    
        $datas = News::all();
        return view('home', compact(
            'datas'
        ))->with('i', ($request->input('page', 1) - 1) * $pagination);;
        $data['news'] = News::paginate(10);

       
    
    



    }
}
