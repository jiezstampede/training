<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeedbackRequest;

use Image; 
use Acme\Facades\Activity;
use Illuminate\Support\Facades\Auth;

use App\Feedback;
use App\FeedbacksType;
use App\Asset;
use App\Seo;

use Acme\Facades\SumoImage;
use Acme\Facades\Asset as AssetHelper;

class FeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        if ($name = $request->name) {
            $feedbacks = Feedback::where('name', 'LIKE', $name . '%')
                                ->orWhere('email', 'LIKE', $name . '%')
                                ->orWhere('phone', 'LIKE', $name . '%')
                                ->orWhere('subject', 'LIKE', $name . '%')
                                ->orWhere('message', 'LIKE', $name . '%')
                                ->latest()->paginate(25);
        } else {
            $feedbacks = Feedback::latest()->paginate(25);
        }
        $pagination = $feedbacks->appends($request->except('page'))->links();

        return view('admin/feedbacks/index')
            ->with('title', 'Feedbacks')
            ->with('menu', 'feedbacks')
            ->with('keyword', $request->name)
            ->with('data', $feedbacks)
            ->with('pagination', $pagination);
    }

    public function datatable()
    {
        return view('admin/feedbacks/datatable')->with('data', Feedback::all());
    }
    
    public function create()
    {
        return view('admin/feedbacks/create')
            ->with('title', 'Create Feedback')
            ->with('menu', 'feedbacks');
    }
    
    public function store(FeedbackRequest $request)
    {
        $input = $request->all();

        $sample = Feedback::create($input);
        $group = AssetHelper::sync($sample, $input['main_images']);

        $log = 'creates a new sample "' . $sample->name . '"';
        Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to edit.',
            'resetForm'=>true,
            'redirect'=>route('adminFeedbacksEdit', [$sample->id])
        ];

        return response()->json($response);
    }
    
    public function show($id)
    {
        return view('admin/feedbacks/show')
            ->with('title', 'Show Feedback')
            ->with('sample', Feedback::findOrFail($id));
    }

    public function view($id)
    {
        $data = Feedback::findOrFail($id);

        return view('admin/feedbacks/view')
            ->with('title', 'View Feedback')
            ->with('menu', 'feedbacks')
            ->with('data', $data);
    }
    
    public function edit($id)
    {
        $data = Feedback::findOrFail($id);
        $seo = $data->seo->first();

        $mainImages = '';
        if ($data->assetGroups()->getResults()->where('name','FeedbackMainImages')->count() > 0) {

            $mainImages = $data->assetGroups()->getResults()->where('name', 'FeedbackMainImages')[0];

            $mainImages->assets = $mainImages->assets()->with('asset')->get();
        }

        return view('admin/feedbacks/edit')
            ->with('title', 'Edit Feedback')
            ->with('menu', 'feedbacks')
            ->with('data', $data)
            ->with('mainImages', $mainImages)
            ->with('seo', $seo);
    }

    public function update(FeedbackRequest $request, $id)
    {
        $input = $request->all();

        $sample = Feedback::findOrFail($id);
        $sample->name = $input['name'];
        $sample->range = $input['range'];
        $sample->image = $input['image'];
        $sample->runes = $input['runes'];
        $sample->embedded_rune = $input['embedded_rune'];
        $sample->evaluation = $input['evaluation'];
        $sample->save();
        $group = AssetHelper::sync($sample, $input['main_images']);

        $log = 'edits a sample "' . $sample->name . '"';
        Activity::create($log);

        $response['notifTitle'] = 'Save successful.';

        return response()->json($response);
    }

    public function seo(Request $request)
    {
        $input = $request->all();

        $data = Feedback::findOrFail($input['seoable_id']);
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

        $feedbacks = Feedback::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($feedbacks as $s) {
            $names[] = $s->name;
        }
        $log = 'deletes a new sample "' . implode(', ', $names) . '"';
        Activity::create($log);

        Feedback::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminFeedbacks')
        ];

        return response()->json($response);
    }

    public function crop_url(Request $request)
    {
        $input = $request->all();
        $response = [
            'redirect'=>route('adminFeedbacksCropForm', [$input['id'], $input['column'], $input['asset_id']])
        ];

        return response()->json($response);
    }

    public function crop_form($id, $column, $asset_id)
    {
        $dimensions = ['width'=>300, 'height'=>300];

        return view('admin/feedbacks/crop')
            ->with('title', 'Crop Image')
            ->with('data', Feedback::findOrFail($id))
            ->with('column', $column)
            ->with('asset', Asset::findOrFail($asset_id))
            ->with('dimensions', $dimensions);
    }

    public function crop(Request $request, $id)
    {
        $input = $request->all();
        $asset = Asset::findOrFail($input['asset_id']);
        
        $filename = str_slug('sample-' . $id . '-' . $input['column']);
        $image = Image::make($asset->path);
        $thumbnail = 'upload/thumbnails/' . $filename . '.' . $image->extension;
        $image->crop($input['crop_width'], $input['crop_height'], $input['x'], $input['y'])
            ->resize($input['target_width'], $input['target_height'])
            ->save($thumbnail, 100);

        $sample = Feedback::findOrFail($id);
        $sample->$input['column'] = $thumbnail;
        $sample->save();

        $log = 'crops image thumbnail of sample "' . $sample->name . '"';
        Activity::create($log);

        $response = [
            'notifTitle'=>'Crop successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminFeedbacksCropForm', [$sample->id, $input['column'], $asset->id])
        ];

        return response()->json($response);
    }
}
