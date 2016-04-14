<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Article;
use App\Http\Requests\ArticleRequest;
use Response;

class ArticleController extends Controller
{   
    public function index(){
        $articles = Article::orderBy('id', 'DESC')->get();
        return view('admin.pages.article', array('articles' => $articles, 'menuActive' => 'article'));
    }

    public function store(ArticleRequest $request){
        $article = Article::create($request->all());
        return Response::json(['flash_message' => 'Đã thêm bài viết!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    public function show($id){
        $article = Article::findOrFail($id);
        return Response::json($article);
    }
     public function edit($id){
        $article = Article::findOrFail($id);
        return Response::json($article);
    }

    public function update($id, ArticleRequest $request){
        Article::findOrFail($id)->update($request->all());
        return Response::json(['flash_message' => 'Đã cập nhật bài viết!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    public function destroy(ArticleRequest $request){
        if (is_string($request->ids)) {
            $article_ids = explode(' ', $request->ids);
            foreach ($article_ids as $article_id) {
                if ($article_id != NULL) {
                    Article::findOrFail($article_id)->delete();
                }
            }
        }
        return Response::json(['flash_message' => 'Đã xóa bài viết!', 'message_level' => 'success', 'message_icon' => 'check']);
    }
}
