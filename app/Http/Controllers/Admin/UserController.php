<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Controllers\Controller;
use App\User;
use App\UserRole;
use Hash;
use SumoMail;

use Acme\Facades\Activity;
use Acme\Facades\Option;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        $this->middleware('super', ['only' => ['edit', 'update']]);
    }

    public function index(Request $request)
    {
        if ($name = $request->name) {
            $users = User::where('name', 'LIKE', '%' . $name . '%')->orWhere('email', 'LIKE', '%' . $name . '%')->paginate(25);
        } else {
            $users = User::paginate(25);
        }
        $pagination = $users->appends($request->except('page'))->links();

        return view('admin/users/index')
            ->with('title', 'Users')
            ->with('menu', 'users')
            ->with('keyword', $request->name)
            ->with('data', $users)
            ->with('pagination', $pagination);
    }

    public function datatable()
    {
        return view('admin/users/datatable')->with('data', User::all());
    }

    public function create()
    {
        $user_roles = UserRole::lists('name','id');
        return view('admin/users/create')
            ->with('user_roles',$user_roles)
            ->with('title', 'Create User');
    }
    
    public function store(UserStoreRequest $request)
    {
        $input = $request->all();
        $options = Option::email();

        $data = [];
        $data['user'] = $input;
        $data['password'] = str_random(8);
        $data['options'] = $options;
      
        $params=[];
        $params['from_email'] = $options['email'];
        $params['from_name'] =$options['name'];
        $params['subject'] = $options['name'] . ': User account created';
        $params['to'] = $input['email'];

        //not required fields
        $params['replyTo'] =  $options['email'];

        //DEBUG Options are as follows:
        // FALSE - Default
        // TRUE - Shows HTML output upon sending
        // SIMULATE = Does not send email but saves information to the database
        $params['debug'] = false; 
            
        $return= SumoMail::send('emails.user-create', $data, $params);

        
        
        $user = new User;
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->cms = $input['cms'];
        $user->password = bcrypt($data['password']);
        $user->verified = 1;
        $user->status = 'active';
        $user->type = $input['type'];
        $user->user_role_id = $input['user_role_id'];
        $user->save();

        $log = 'creates a new user "' . $user->name . '"';
        Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to users list.',
            'resetForm'=>true,
            'redirect'=>route('adminUsers')
        ];

        return response()->json($response);
    }

    public function show($id)
    {
        return view('admin/users/show')
            ->with('title', 'Show User')
            ->with('user', User::findOrFail($id));
    }

    public function edit($id)
    {
        $user_roles = UserRole::lists('name','id');
        return view('admin/users/edit')
            ->with('title', 'Edit User')
            ->with('menu', 'users')
            ->with('user_roles',$user_roles)
            ->with('user', User::findOrFail($id));
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $input = $request->all();

        $user = User::findOrFail($id);
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->cms = $input['cms'];
        $user->type = $input['type'];
        $user->user_role_id = $input['user_role_id'];
        $user->save();

        $log = 'edits a user "' . $user->name . '"';
        Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
        ];

        return response()->json($response);
    }

    public function destroy(Request $request)
    {
        $input = $request->all();

        $samples = User::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($samples as $s) {
            $names[] = $s->name;
        }
        $log = 'deletes a new sample "' . implode(', ', $names) . '"';
        Activity::create($log);

        User::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminUsers')
        ];

        return response()->json($response);
    }
}
