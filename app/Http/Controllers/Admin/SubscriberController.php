<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriberRequest;

use Acme\Facades\Activity;

use App\Subscriber;
use App\Seo;

class SubscriberController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index(Request $request)
    {
        if ($name = $request->name) {
            $data = Subscriber::where('name', 'LIKE', '%' . $name . '%')->paginate(25);
        } else {
            $data = Subscriber::paginate(25);
        }
        $pagination = $data->appends($request->except('page'))->links();

        return view('admin/subscribers/index')
            ->with('title', 'Subscribers')
            ->with('menu', 'subscribers')
            ->with('keyword', $request->name)
            ->with('data', $data)
            ->with('pagination', $pagination);
    }

    public function create()
    {
        return view('admin/subscribers/create')
            ->with('title', 'Create subscriber')
            ->with('menu', 'subscribers');
    }
    
    public function store(SubscriberRequest $request)
    {
        $input = $request->all();
        $subscriber = Subscriber::create($input);
        
        // $log = 'creates a new subscriber "' . $subscriber->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to edit.',
            'resetForm'=>true,
            'redirect'=>route('adminSubscribersEdit', [$subscriber->id])
        ];

        return response()->json($response);
    }
    
    public function show($id)
    {
        return view('admin/subscribers/show')
            ->with('title', 'Show subscriber')
            ->with('data', Subscriber::findOrFail($id));
    }

    public function view($id)
    {
        return view('admin/subscribers/view')
            ->with('title', 'View subscriber')
            ->with('menu', 'subscribers')
            ->with('data', Subscriber::findOrFail($id));
    }
    
    public function edit($id)
    {
        $data = Subscriber::findOrFail($id);
        $seo = $data->seo()->first();

        return view('admin/subscribers/edit')
            ->with('title', 'Edit subscriber')
            ->with('menu', 'subscribers')
            ->with('data', $data)
            ->with('seo', $seo);
    }
    
    public function update(SubscriberRequest $request, $id)
    {
        $input = $request->all();
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->update($input);

        // $log = 'edits a subscriber "' . $subscriber->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
        ];

        return response()->json($response);
    }

    public function seo(Request $request)
    {
        $input = $request->all();

        $data = Subscriber::findOrFail($input['seoable_id']);
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

        $data = Subscriber::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($data as $d) {
            $names[] = $d->name;
        }
        // $log = 'deletes a new subscriber "' . implode(', ', $names) . '"';
        // Activity::create($log);

        Subscriber::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminSubscribers')
        ];

        return response()->json($response);
    }
    
/** Copy/paste these lines to app\Http\routes.base.php 
Route::get('admin/subscribers', array('as'=>'adminSubscribers','uses'=>'Admin\SubscriberController@index'));
Route::get('admin/subscribers/create', array('as'=>'adminSubscribersCreate','uses'=>'Admin\SubscriberController@create'));
Route::post('admin/subscribers/', array('as'=>'adminSubscribersStore','uses'=>'Admin\SubscriberController@store'));
Route::get('admin/subscribers/{id}/show', array('as'=>'adminSubscribersShow','uses'=>'Admin\SubscriberController@show'));
Route::get('admin/subscribers/{id}/view', array('as'=>'adminSubscribersView','uses'=>'Admin\SubscriberController@view'));
Route::get('admin/subscribers/{id}/edit', array('as'=>'adminSubscribersEdit','uses'=>'Admin\SubscriberController@edit'));
Route::patch('admin/subscribers/{id}', array('as'=>'adminSubscribersUpdate','uses'=>'Admin\SubscriberController@update'));
Route::post('admin/subscribers/seo', array('as'=>'adminSubscribersSeo','uses'=>'Admin\SubscriberController@seo'));
Route::delete('admin/subscribers/destroy', array('as'=>'adminSubscribersDestroy','uses'=>'Admin\SubscriberController@destroy'));
*/
}
