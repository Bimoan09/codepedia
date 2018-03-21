<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin\Article;
class SearchController extends Controller
{

  public function search(Request $request){
     if($request->has('search')){

        $articles = Article::search($request->input('search'))->paginate(10);
     }
     return view('search.result', compact('index'));
   }
//
//
//  -->
//
//
//
}
