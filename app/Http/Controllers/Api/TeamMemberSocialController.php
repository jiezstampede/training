<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\TeamMemberSocial;

class TeamMemberSocialController extends Controller
{
    public function find(Request $request)
    {
        $response = [];
        $input = $request->all();
        $data = TeamMemberSocial::find($input['id']);

        if (! is_null($data)) {
            $response['data'] = $data;
            $response['message'] = 'Successfully retrieved data.';
            $status = 200;
        } else {
            $response['message'] = 'Failed to retrieve data.';
            $status = 404;
        }

        return response($response, $status);
    }

    public function get(Request $request)
    {
        $response = [];
        $input = $request->all();

        $data = new TeamMemberSocial;
        if (isset($input['skip']) && isset($input['take'])) {
            $data = $data->skip($input['skip'])->take($input['take']);
        }
        // FILTER DATA
        // $data->whereParam1('value1');
        // $data->whereParam2('value2');
        $data = $data->_paginate($data, $request, $input);

        if (! is_null($data)) {
            $response['data'] = $data;
            $response['message'] = 'Successfully retrieved data.';
            $status = 200;
        } else {
            $response['message'] = 'Failed to retrieve data.';
            $status = 400;
        }


        return response($response, $status);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $data = TeamMemberSocial::create($input);

        if ($data) {
            $response = [];
            $response['message'] = 'Successfully created data.';
            $response['data'] = $data;
            $status = 201;
        } else {
            $response = [];
            $response['message'] = 'Failed to create data.';
            $status = 400;
        }

        return response($response, $status);
    }

    public function update(Request $request)
    {
        $input = $request->all();
        $data = TeamMemberSocial::find($input['id']);
        $data->update($input);

        if (! is_null($data)) {
            $response = [];
            $response['message'] = 'Successfully updated data.';
            $response['data'] = $data;
            $status = 200;
        } else {
            $response = [];
            $response['message'] = 'Failed to update data.';
            $status = 400;
        }

        return response($response, $status);
    }

    public function destroy(Request $request)
    {
        $input = $request->all();
        TeamMemberSocial::destroy($input['id']);

        $response = [];
        $response['message'] = 'Successfully deleted data.';
        $status = 200;

        return response($response, $status);
    }

/** Copy/paste these lines to app\Http\routes.api.php 
Route::get('api/team_member_socials/find', array('as'=>'apiTeamMemberSocialsFind','uses'=>'TeamMemberSocialController@find', 'middleware'=>'cors'));
Route::get('api/team_member_socials/get', array('as'=>'apiTeamMemberSocialsGet','uses'=>'TeamMemberSocialController@get', 'middleware'=>'cors'));
Route::post('api/team_member_socials/store', array('as'=>'apiTeamMemberSocialsStore','uses'=>'TeamMemberSocialController@store', 'middleware'=>'cors'));
Route::post('api/team_member_socials/update', array('as'=>'apiTeamMemberSocialsUpdate','uses'=>'TeamMemberSocialController@update', 'middleware'=>'cors'));
Route::post('api/team_member_socials/destroy', array('as'=>'apiTeamMemberSocialsDestroy','uses'=>'TeamMemberSocialController@destroy', 'middleware'=>'cors'));
*/
}
