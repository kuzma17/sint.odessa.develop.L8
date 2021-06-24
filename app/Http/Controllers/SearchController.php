<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;


class SearchController extends Controller
{
    public function search(Request $request){
        if($request->isMethod('post')) {

            $this->validate($request, ['search' => 'required|min:4'] );

            $res = collect();
            $query = $request->input('search');
            $pages = $this->getPages($query);
            $news = $this->getNews($query);

            $res = $res->merge($pages)->merge($news);

            return view('search', ['query' => $query, 'results' => $res]);
        }
    }

    public function getPages($keywords)
    {
        return $news = Page::search($keywords)->get();
    }

    public function getNews($keywords)
    {
        return $news = News::search($keywords)->get();

    }

}
