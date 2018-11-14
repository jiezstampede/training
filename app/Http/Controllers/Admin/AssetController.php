<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Asset;
use App\Tag;
use Illuminate\Support\Facades\Storage;

use Acme\Facades\SumoImage;

class AssetController extends Controller
{
  private $upload_path = './upload/assets';
  private $redactor_path = './upload/redactor';
  private $upload_path_s3 = 'upload/assets/';
  private $redactor_path_s3 = 'upload/redactor/';
  private $s3_active = NULL;

  public function __construct()
  {
    //Convert env S3_ACTIVE to boolean
    $s3_active = strtolower(getenv('S3_ACTIVE'));
    $this->s3_active = ($s3_active == "true");
  }

  public function upload(Request $request)
  {
    $s3 = Storage::disk('s3');
    $input = $request->all();
    $response = [];
    if ($request->hasFile('photo')) {
      $photo = $request->file('photo');

      $asset = new Asset;

      /*
       * GIFs shouldn't be resized.
       */
      // if ($input['type'] == 'image') {
      if ($input['type'] == 'image' && @getimagesize($input["photo"])["mime"] !== "image/gif"){
        $data = SumoImage::upload($photo, 'upload/assets/',$this->s3_active);
        $asset->path = $data['paths']['main'];
        $asset->medium_thumbnail = $data['paths']['medium'];
        $asset->small_thumbnail = $data['paths']['small'];
        $response['filepath'] = '';
        if($this->s3_active){
          $response['filepath'] = $s3->url($data['paths']['small']);
        } else {
          $response['filepath'] = url($data['paths']['small']);
        }
      } else {
        $filename = str_random(50) . '.' . $photo->getClientOriginalExtension();

        if($this->s3_active) {
          $s3->put($this->upload_path_s3.$filename,file_get_contents($request->file('photo')),'public');
          $filepath = $s3->url($this->upload_path_s3 . $filename);
        } else {
          $photo->move($this->upload_path, $filename);
          $asset->path = 'upload/assets/' . $filename;
        }
        $response['filepath'] = SumoImage::defaultImageProcessor($asset->path);
      }

      $asset->name = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
      $asset->type = SumoImage::fileTypeIdentifier($photo->getClientOriginalName());
      $asset->save();

      $this->processTags($asset, $input);

      $response['id'] = $asset->id;
      $response['name'] = $asset->name;
      return response()->json($response);
    }
  }

  public function redactor(Request $request)
  {
    $s3 = Storage::disk('s3');
    if ($request->hasFile('file')) {
      $photo = $request->file('file');
      $filename = str_random(50) . '.' . $photo->getClientOriginalExtension();
      $response = [];
      if($this->s3_active) {
        $fullPath = $this->redactor_path_s3 . $filename;
        $s3->put($fullPath,file_get_contents($request->file('file')),'public');
        $filepath = $s3->url($fullPath);
        $response = [
          'url'=>$filepath,
          'filelink' => $filepath,
          'path' => $filepath
        ];
      } else {
        $photo->move($this->redactor_path, $filename);
        $filepath = $this->redactor_path . '/' . $filename;
        $response = [
          'url'=>url($filepath),
          'filelink' => url($filepath),
          'path' => $this->redactor_path
        ];
      }
      return response()->json($response);
    }
  }

  public function all(Request $request)
  {
    $s3 = Storage::disk('s3');
    $batch = 20;

    $sortOrder = $request['sortBy']['order'];
    $sortBy = $request['sortBy']['by'];

    $filterByDate = 'created_at';
    $filterByDateFrom = '1900-1-1'; // default for $filterByDateFrom if not set
    $filterByDateTo = '2100-12-31'; // default for $filterByDateTo if not set

    if(isset($request['filterBy']['date'])){
      $filterByDateFrom = $request['filterBy']['from'];
      $filterByDateTo = $request['filterBy']['to'];
      $filterByDateTo = str_replace('-', '/', $filterByDateTo);
      $filterByDateTo = date('Y-m-d',strtotime($filterByDateTo . "+1 days"));
    }

    $filterByColumn = "type"; // default for $filterByWhere if not set *this is for what column for where
    $filterByOperator = "<>"; // default for $filterByWhere if not set and filterBy filetype is all *this is for what operator to use
    $filterByValue = "''"; // default for $filterByWhere if not set and filterBy filetype is all
    if(isset($request['filterBy']['fileType']) AND $request['filterBy']['fileType'] != 'all'){
      $filterByOperator = "=";
      $filterByValue = $request['filterBy']['fileType'];
    }

    $assets = New Asset;
    DB::enableQueryLog();

    $assets = $assets->skip($request['count'])->take($batch)
                      ->where('name', 'like', $request['searchInput'].'%')
                      ->where($filterByColumn, $filterByOperator, $filterByValue)
                      ->whereBetween($filterByDate,[$filterByDateFrom,$filterByDateTo])
                      ->orderBy($sortOrder, $sortBy);

    if (!empty($request['tags'])) {
      $assets = $assets->where($filterByColumn, $filterByOperator, $filterByValue)
                        ->where('name', 'like', $request['searchInput'].'%')
                        ->whereBetween($filterByDate,[$filterByDateFrom,$filterByDateTo])
                        ->whereHas('tags', function($query) use ($request) {
                          $query->whereIn('name', explode(',', $request['tags']))
                                ->where('taggable_type','App\Asset');
      });
    }

    $assets = $assets->get();
    // dd(DB::getQueryLog());
    // dd($assets);
    foreach ($assets as $a) {
      if ($a->type == 'image') {
        if($this->s3_active) {
          $a->mime_path = $s3->url($a->path);
        } else {
          $a->mime_path = url($a->path);
        }
      } else {
        $a->mime_path = SumoImage::defaultImageProcessor($a->path);
      }
    }

    $view = view('admin/modals/assets-list')
      ->with('assets', $assets)
      ->render();

    $next = Asset::skip($request['count'] + $batch)->take($batch)
                                                    ->where('name', 'like', $request['searchInput'].'%')
                                                    ->where($filterByColumn, $filterByOperator, $filterByValue)
                                                    ->whereBetween($filterByDate,[$filterByDateFrom,$filterByDateTo])
                                                    ->orderBy($sortOrder, $sortBy);

    if (!empty($request['tags'])) {
      $next = Asset::skip($request['count'] + $batch)->take($batch)
                                                      ->where('name', 'like', $request['searchInput'].'%')
                                                      ->where($filterByColumn, $filterByOperator, $filterByValue)
                                                      ->whereBetween($filterByDate,[$filterByDateFrom,$filterByDateTo])
                                                      ->whereHas('tags', function($query) use ($request) {
                                                        $query->whereIn('name', explode(',', $request['tags']))
                                                              ->where('taggable_type','App\Asset');
      });
    }

    $next = $next->get();

    $response = [
    'view'=>$view,
    'next'=>count($next)
    ];
    return response($response);
  }

  public function get(Request $request)
  {
    $s3 = Storage::disk('s3');
    $input = $request->all();
    $asset = Asset::with('tags')->find($input['id']);

    if ($asset->type == 'image') {
        if($this->s3_active) {
          $asset->absolute_path = $s3->url($asset->path);
        } else {
          $asset->absolute_path = url($asset->path);
        }
    } else {
      $asset->absolute_path = SumoImage::defaultImageProcessor($asset->path);
    }
    return response()->json($asset);
  }

  public function getAssetTags(Request $request)
  {
    $response = Tag::select(array('id','name'))
                    ->groupBy('name')
                    ->where('taggable_type', '=', 'App\Asset')
                    ->orderBy('name', 'ASC')
                    ->get();
    return response()->json($response);
  }

  public function download(Request $request)
  {
    $s3 = Storage::disk('s3');
    $input = $request->all();
    $asset = Asset::find($input['id']);
    if($this->s3_active) {
      $file_url = $s3->url($asset->path);
      header('Content-Type: application/octet-stream');
      header("Content-Transfer-Encoding: Binary"); 
      header("Content-disposition: attachment; filename=\"" . $asset->name . '.' . pathinfo($asset->path)['extension'] . "\""); 
      readfile($file_url);
    } else {
      return response()->download($asset->path);
    }
  }

  // added karlob - save tags
  public function processTags($asset, $input) {
    $asset->tags()->delete();
    if (isset($input['tags'])) {
      $tags = explode(",", $input['tags']);
      foreach ($tags as $key => $value) {
        $tag = New Tag;
        if (!empty($value)) {
          $tag->name = str_slug($value);
          $asset->tags()->save($tag);
        }
      }
    }
  }
  // end add karlob

  public function update(Request $request)
  {
    $input = $request->all();
    $asset = Asset::with('tags')->findOrFail($input['id']);
    $asset->name = $input['name'];
    $asset->caption = $input['caption'];
    $asset->alt = $input['alt'];
    $asset->save();

    $this->processTags($asset, $input);

    $response = [
      'notifTitle'=>'Save successful.',
    ];
    return response()->json($response);
  }

  public function destroy(Request $request)
  {
    $input = $request->all();
    $filepath = Asset::select('path')->where('id',$input['id'])->first();
    if($this->s3_active) {
      $asset = Asset::findOrFail($input['id']);
      Storage::disk('s3')->delete($asset->first()->path);
      $asset->delete();
      Tag::where('taggable_type','App\Asset')->where('taggable_id',$input['id'])->delete();
      $response = [
        'notifTitle'=>'Delete successful.',
      ];
    } else {
      if(unlink($filepath->path)) {
        Asset::findOrFail($input['id'])->delete();
        Tag::where('taggable_type','App\Asset')->where('taggable_id',$input['id'])->delete();
        $response = [
          'notifTitle'=>'Delete successful.',
        ];
      }else{
        $response = [
          'notifTitle'=>'Failed to delete asset.',
        ];
      }
    }
    return response()->json($response);
  }

}
