<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;

use App\Activity;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function index(Request $request)
    {
        if ($log = $request->log) {
            $activities = Activity::where('identifier_value', 'LIKE',  $log . '%')
                            ->with('user')
                            ->latest()
                            ->paginate(25);
        } else {
            $activities = Activity::with('user')
                            ->latest()
                            ->paginate(25);
        }
        $pagination = $activities->appends($request->except('page'))->links();

        return view('admin/activities/index')
            ->with('title', 'Activity')
            ->with('menu', 'activities')
            ->with('keyword', $request->product_id)
            ->with('data', $activities)
            ->with('pagination', $pagination);
    }

    public function view($id)
    {
        return view('admin/activities/view')
            ->with('title', 'View activity')
            ->with('menu', 'activities')
            ->with('data', Activity::findOrFail($id));
    }
}
