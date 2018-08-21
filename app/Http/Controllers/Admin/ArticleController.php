<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin\Article;
use App\Admin\Category;
use Auth;
use DB;
use File;
use Carbon\Carbon;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['articles'] = Article::where('user_id', Auth::user()->id)
                            ->orderBy('created_at', 'DESC')->paginate(50);

        return view('admin.articles.index', $data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories'] = Category::where('is_active', TRUE)->get();

        return view('admin.articles.create', $data);
    }

    // public function search($id){
    //   $cari = $request->get('search');
    //   $Title = Article::where('title', 'LIKE', '%' .$cari . '%')->paginate(10);
    //   return view('/article/show', $cari);
    // }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $article = new Article;
            $article->user_id = Auth::user()->id;
            // $article->created_at= Carbon::now($article->created_at)->diffForHumans();
            $article->category_id = $request->category_id;
            $article->title = $request->title;
            $article->content = $request->content;
            // $article->header_pic = $getimageName;
            if(!$request->is_active)
            {
                $category->is_active = false;
            }
            $article->save();

            $request->session()->flash('alert-success','Data successfully saved');

            DB::commit();

            return redirect(route('articles.index'));
        } catch (Exception $e) {
            return Redirect::back()->with('error-message', $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['article'] = Article::find($id);

        return view('admin.articles.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['categories'] = Category::where('is_active', TRUE)->get();
        $data['article'] = Article::find($id);

        return view('admin.articles.edit', $data);
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
        try {
            DB::beginTransaction();
            $article = Article::find($id);
            $article->user_id = Auth::user()->id;
            $article->category_id = $request->category_id;
            $article->title = $request->title;
            $article->content = $request->content;
            if($request->header_pic)
            {
                $article->header_pic = $getimageName;
            }
            if(!$request->is_active)
            {
                $category->is_active = false;
            }
            $article->save();

            $request->session()->flash('alert-success','Data successfully saved');

            DB::commit();

            return redirect(route('articles.index'));
        } catch (Exception $e) {
            return Redirect::back()->with('error-message', $e->getMessage())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        try {
            DB::beginTransaction();

            $article = Article::find($id);
            $article->delete();

            $request->session()->flash('alert-success','Data successfully deleted');

            DB::commit();

            return redirect(route('articles.index'));
        }
        catch (Exception $e) {
            return Redirect::back()->with('error_message', $e->getMessage())->withInput();
        }
    }

    public function activated(Request $request,$id)
    {
        try {
            DB::beginTransaction();

            $article = Article::find($id);
            $article->is_show = TRUE;
            $article->save();

            $request->session()->flash('alert-success','Data successfully activated');

            DB::commit();

            return redirect(route('articles.index'));
        }
        catch (Exception $e) {
            return Redirect::back()->with('error_message', $e->getMessage())->withInput();
        }
    }

    public function deactivatedArticle(Request $request,$id)
    {
        try {
            DB::beginTransaction();

            $article = Article::find($id);
            $article->is_show = FALSE;
            $article->save();

            $request->session()->flash('alert-success','Data successfully deactivated');

            DB::commit();

            return redirect(route('articles.index'));
        }
        catch (Exception $e) {
            return Redirect::back()->with('error_message', $e->getMessage())->withInput();
        }
    }
}
