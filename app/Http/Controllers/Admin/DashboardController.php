<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;

use App\Activity;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function index(Request $request)
    {
        $quote = "Do or do not. There is no try";
        $quote_by = "Yoda";

        try {
            $quote = @file_get_contents('http://quotesondesign.com/wp-json/posts?filter[orderby]=rand&filter[posts_per_page]=1');
            $res = json_decode($quote, TRUE);

            $quote = $res[0]['content'];
            $quote_by = $res[0]['title'];

        } catch (Exception $e) {
            if (empty($quote)) {
                $quote = "Do or do not. There is no try.";
                $quote_by = "Yoda";
            }
        }

        $activities = Activity::latest()->paginate(25);
        $pagination = $activities->appends($request->except('page'))->links();

        return view('admin/dashboard/index')
            ->with('title', 'Dashboard')
            ->with('quote', $quote)
            ->with('quote_by', $quote_by)
            ->with('activities', $activities)
            ->with('pagination', $pagination)
            ->with('menu', 'dashboard');
    }
}
