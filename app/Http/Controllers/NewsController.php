<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Settings;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(){
        $news = News::where('published', 1)->orderBy('published_at', 'desc')->paginate(News::count());
        return view('news.index', ['news'=>$news]);
    }
    public function news($id){
        $news = News::find($id);
        return view('news.news', ['news'=>$news]);
    }
}
