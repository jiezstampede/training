<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmailRequest;

use Acme\Facades\Activity;

use App\Email;
use App\Seo;

class EmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index(Request $request)
    {
        if ($to = $request->to) {
            $data = Email::where('to', 'LIKE', '%' . $to . '%')->paginate(25);
        } else {
            $data = Email::paginate(25);
        }
        $pagination = $data->appends($request->except('page'))->links();

        return view('admin/emails/index')
            ->with('title', 'Emails')
            ->with('menu', 'emails')
            ->with('keyword', $request->to)
            ->with('data', $data)
            ->with('pagination', $pagination);
    }

    public function create()
    {
        return view('admin/emails/create')
            ->with('title', 'Create email')
            ->with('menu', 'emails');
    }
    
    public function store(EmailRequest $request)
    {
        $input = $request->all();
        $email = Email::create($input);
        
        // $log = 'creates a new email "' . $email->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to edit.',
            'resetForm'=>true,
            'redirect'=>route('adminEmailsEdit', [$email->id])
        ];

        return response()->json($response);
    }
    
    public function show($id)
    {
        return view('admin/emails/show')
            ->with('title', 'Show email')
            ->with('data', Email::findOrFail($id));
    }

    public function view($id)
    {
        return view('admin/emails/view')
            ->with('title', 'View email')
            ->with('menu', 'emails')
            ->with('data', Email::findOrFail($id));
    }
    
    public function edit($id)
    {
        $data = Email::findOrFail($id);
        $seo = $data->seo()->first();

        return view('admin/emails/edit')
            ->with('title', 'Edit email')
            ->with('menu', 'emails')
            ->with('data', $data)
            ->with('seo', $seo);
    }
    
    public function update(EmailRequest $request, $id)
    {
        $input = $request->all();
        $email = Email::findOrFail($id);
        $email->update($input);

        // $log = 'edits a email "' . $email->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
        ];

        return response()->json($response);
    }

    public function seo(Request $request)
    {
        $input = $request->all();

        $data = Email::findOrFail($input['seoable_id']);
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

        $data = Email::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($data as $d) {
            $names[] = $d->subject;
        }
        // $log = 'deletes a new email "' . implode(', ', $names) . '"';
        // Activity::create($log);

        Email::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminEmails')
        ];

        return response()->json($response);
    }
    
/** Copy/paste these lines to app\Http\routes.base.php 
Route::get('admin/emails', array('as'=>'adminEmails','uses'=>'Admin\EmailController@index'));
Route::get('admin/emails/create', array('as'=>'adminEmailsCreate','uses'=>'Admin\EmailController@create'));
Route::post('admin/emails/', array('as'=>'adminEmailsStore','uses'=>'Admin\EmailController@store'));
Route::get('admin/emails/{id}/show', array('as'=>'adminEmailsShow','uses'=>'Admin\EmailController@show'));
Route::get('admin/emails/{id}/view', array('as'=>'adminEmailsView','uses'=>'Admin\EmailController@view'));
Route::get('admin/emails/{id}/edit', array('as'=>'adminEmailsEdit','uses'=>'Admin\EmailController@edit'));
Route::patch('admin/emails/{id}', array('as'=>'adminEmailsUpdate','uses'=>'Admin\EmailController@update'));
Route::post('admin/emails/seo', array('as'=>'adminEmailsSeo','uses'=>'Admin\EmailController@seo'));
Route::delete('admin/emails/destroy', array('as'=>'adminEmailsDestroy','uses'=>'Admin\EmailController@destroy'));
*/
}
