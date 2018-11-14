<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;

use Acme\Facades\Activity;
use Acme\Facades\General;
use App\Article;
use App\Seo;

use Image;
use App\Asset;
use App\Tag;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index(Request $request)
    {
        if ($name = $request->name) {
            $data = Article::where('name', 'LIKE', '%' . $name . '%')->orderBy('featured', 'DESC')->paginate(25);
        } else {
            $data = Article::orderBy('featured', 'DESC')->paginate(25);
        }
        $pagination = $data->appends($request->except('page'))->links();

        return view('admin/articles/index')
            ->with('title', 'Articles')
            ->with('menu', 'articles')
            ->with('keyword', $request->name)
            ->with('data', $data)
            ->with('pagination', $pagination);
    }

    public function create()
    {
        return view('admin/articles/create')
            ->with('title', 'Create article')
            ->with('menu', 'articles')
            ->with('tag_list',Tag::where('taggable_type','App\Article')->groupBy('name')->lists('name','name'));
    }
    
    public function store(ArticleRequest $request)
    {
        $input = $request->all();
        $article = Article::create($input);

        if(isset($input['tags'])){
            $article->tags()->delete();
            foreach ($input['tags'] as $value) {
                $tag = New Tag;
                if (!empty($value)) {
                  $tag->name = str_slug($value);
                  $article->tags()->save($tag);
                }
            }
        }

        $input['slug'] = General::slug($article->name,$article->id);
        $article->update($input);

        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to edit.',
            'resetForm'=>true,
            'redirect'=>route('adminArticlesEdit', [$article->id])
        ];

        return response()->json($response);
    }
    
    public function show($id)
    {
        return view('admin/articles/show')
            ->with('title', 'Show article')
            ->with('data', Article::findOrFail($id));
    }

    public function view($id)
    {
        return view('admin/articles/view')
            ->with('title', 'View article')
            ->with('menu', 'articles')
            ->with('data', Article::findOrFail($id));
    }
    
    public function edit($id)
    {
        $data = Article::findOrFail($id);
        $seo = $data->seo()->first();
        $tags = array();
        if($data->tags){
            foreach ($data->tags as $tag) {
                $tags[] = $tag->name;
            }
        }
        $data->tags = $tags;

        return view('admin/articles/edit')
            ->with('title', 'Edit article')
            ->with('menu', 'articles')
            ->with('data', $data)
            ->with('seo', $seo)
            ->with('tag_list',Tag::where('taggable_type','App\Article')->groupBy('name')->lists('name','name'));
    }

    public function update(ArticleRequest $request, $id)
    {
        $input = $request->all();
        $article = Article::findOrFail($id);

        if(isset($input['tags'])){
            $article->tags()->delete();
            foreach ($input['tags'] as $value) {
                $tag = New Tag;
                if (!empty($value)) {
                  $tag->name = str_slug($value);
                  $article->tags()->save($tag);
                }
            }
        }

        $article->update($input);

        $response = [
            'notifTitle'=>'Save successful.',
        ];

        return response()->json($response);
    }

    public function seo(Request $request)
    {
        $input = $request->all();

        $data = Article::findOrFail($input['seoable_id']);
        $seo = Seo::whereSeoable_id($input['seoable_id'])->whereSeoable_type($input['seoable_type'])->first();
        if (is_null($seo)) {
            $seo = new Seo;
        }
        $seo->title = $input['title'];
        $seo->description = $input['description'];
        $seo->image = $input['image'];
        $data->seo()->save($seo);

        $response = [
            'notifTitle'=>'SEO Save successful.',
        ];

        return response()->json($response);
    }
    
    public function destroy(Request $request)
    {
        $input = $request->all();

        $data = Article::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($data as $d) {
            $names[] = $d->name;
        }
        // $log = 'deletes a new article "' . implode(', ', $names) . '"';
        // Activity::create($log);

        Article::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminArticles')
        ];

        return response()->json($response);
    }
    
    public function crop_url(Request $request)
    {
        $input = $request->all();
        $response = [
            'redirect'=>route('adminArticlesCropForm', [$input['id'], $input['column'], $input['asset_id']])
        ];

        return response()->json($response);
    }

    public function crop_form($id, $column, $asset_id)
    {
        $dimensions = ['width'=>300, 'height'=>300];

        return view('admin/articles/crop')
            ->with('title', 'Crop Image')
            ->with('data', Article::findOrFail($id))
            ->with('column', $column)
            ->with('asset', Asset::findOrFail($asset_id))
            ->with('dimensions', $dimensions);
    }

    public function crop(Request $request, $id)
    {
        $input = $request->all();
        $asset = Asset::findOrFail($input['asset_id']);
        
        $filename = str_slug('article-' . $id . '-' . $input['column']);
        $image = Image::make($asset->path);
        $thumbnail = 'upload/thumbnails/' . $filename . '.' . $image->extension;
        $image->crop($input['crop_width'], $input['crop_height'], $input['x'], $input['y'])
            ->resize($input['target_width'], $input['target_height'])
            ->save($thumbnail, 100);

        $data = Article::findOrFail($id);
        $data->$input['column'] = $thumbnail;
        $data->save();

        $log = 'crops ' . $input['column'] . ' of article "' . $data->name . '"';
        Activity::create($log);

        $response = [
            'notifTitle'=>'Crop successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminArticlesCropForm', [$data->id, $input['column'], $asset->id])
        ];

        return response()->json($response);
    }

/** Copy/paste these lines to app\Http\routes.base.php 
Route::get('admin/articles', array('as'=>'adminArticles','uses'=>'Admin\ArticleController@index'));
Route::get('admin/articles/create', array('as'=>'adminArticlesCreate','uses'=>'Admin\ArticleController@create'));
Route::post('admin/articles/', array('as'=>'adminArticlesStore','uses'=>'Admin\ArticleController@store'));
Route::get('admin/articles/{id}/show', array('as'=>'adminArticlesShow','uses'=>'Admin\ArticleController@show'));
Route::get('admin/articles/{id}/view', array('as'=>'adminArticlesView','uses'=>'Admin\ArticleController@view'));
Route::get('admin/articles/{id}/edit', array('as'=>'adminArticlesEdit','uses'=>'Admin\ArticleController@edit'));
Route::patch('admin/articles/{id}', array('as'=>'adminArticlesUpdate','uses'=>'Admin\ArticleController@update'));
Route::post('admin/articles/seo', array('as'=>'adminArticlesSeo','uses'=>'Admin\ArticleController@seo'));
Route::delete('admin/articles/destroy', array('as'=>'adminArticlesDestroy','uses'=>'Admin\ArticleController@destroy'));
Route::get('admin/articles/crop/url', array('as'=>'adminArticlesCropUrl','uses'=>'Admin\ArticleController@crop_url'));
Route::get('admin/articles/{id}/crop/{column}/{asset_id}', array('as'=>'adminArticlesCropForm','uses'=>'Admin\ArticleController@crop_form'));
Route::patch('admin/articles/{id}/crop', array('as'=>'adminArticlesCrop','uses'=>'Admin\ArticleController@crop'));
*/
}
