<?php 

namespace Acme\General;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

use App\Option;
use App\Email;
use Mail;
use Carbon;
use App\PageItem;

class General extends Mail
{	
	public function option($slug) {
		$option = Option::whereSlug($slug)->first();
		$response = ($option) ? $option->value: '';
		return $response;
	}
	
	public function profile() {
        return Auth::user();
    }
	public function get_ga_code(){
		$option = Option::whereSlug('analytics-script')->first();
		$response = ($option) ? $option->value: 'TBD';
		return $response;
	}
	
	public function slug($value,$id)
	{
		$slug = str_slug($value."-".$id);
		return $slug;
	}

	public function checkPermission($children,$ids,$curParentId,$data){
		foreach($children as $c){
			if($c->parent==0){

				if(count($c->children)>0){
					echo '<li><input type="checkbox" id="func-'.$c->id.'" name="ids[]" value="'.$c->id.'" '.(in_array($c->id,$data) ? "checked":"").'><label for="func-'.$c->id.'" class="parent header no-margin">';
					echo $c->name;
					echo '</label></li>';
					echo '<ul class="parent permission-list">';
					$this->checkPermission($c->children,$ids,$c->id,$data);
					echo '</ul>';

				}else{
					echo '<li><input type="checkbox" name="ids[]" value="'.$c->id.'" '.(in_array($c->id,$data) ? "checked":"").'><label class="parent header no-margin">';
					echo $c->name;
					echo '</label></li>';
				}
			}
			else if(!in_array($c->id,$ids)){

				if(count($c->children)>0){
					echo '<li><input type="checkbox" id="func-'.$c->id.'" name="ids[]" value="'.$c->id.'" '.(in_array($c->id,$data) ? "checked":"").'><label for="func-'.$c->id.'" class="parent header no-margin">';
					echo $c->name;
					echo '</label></li>';
					echo '<ul class="permission-list">';
					$this->checkPermission($c->children,$ids,$c->id,$data);
					echo '</ul>';

				}else{
					echo '<li><input type="checkbox"  id="func-'.$c->id.'" name="ids[]" name="ids[]" value="'.$c->id.'" '.(in_array($c->id,$data) ? "checked":"").'><label for="func-'.$c->id.'" class="parent header no-margin">';
					echo $c->name;
					echo '</label></li>';
				}
			}
			else if(in_array($c->id,$ids) && $c->parent==$curParentId){

				if(count($c->children)>0){
					echo '<li><input type="checkbox" id="func-'.$c->id.'" name="ids[]" value="'.$c->id.'" '.(in_array($c->id,$data) ? "checked":"").'><label for="func-'.$c->id.'" class="parent header no-margin">';
					echo $c->name;
					echo '</label></li>';
					echo '<ul class="permission-list">';
					$this->checkPermission($c->children,$ids,$c->id,$data);
					echo '</ul>';

				}else{
					echo '<li><input type="checkbox" id="func-'.$c->id.'" name="ids[]" value="'.$c->id.'" '.(in_array($c->id,$data) ? "checked":"").'><label for="func-'.$c->id.'" class="parent header no-margin">';
					echo $c->name;
					echo '</label></li>';
				}
				continue;

			}
		}

	}
	
	public function getIGPosts()
	{
		//needs to create instagram-feed-token in general settings
		// optional instagram-feed-size default value is 8
		$access_token = OptionModel::where('slug','instagram-feed-token')->first();
		
		if ($access_token) {
			
			try {
				
				$endpoint = "https://api.instagram.com/v1/users/self/media/recent/";
				$client = new \GuzzleHttp\Client();
				$limit = OptionModel::where('slug','instagram-feed-size')->first();
				$response = $client->get($endpoint, [ 'query' => [
					'access_token'=> @$access_token->value,
					'count'=> ($limit)? $limit->value:8
				]]);
					
					
				$statusCode = $response->getStatusCode();
				$content = json_decode($response->getBody(), true);
				
				return $content['data'];
				//returns arrays of array not object.
					
					
			} catch (RequestException $e) {
				return null;
			} catch (\Exception $e) {
				return null;
			}

		} else {
			return null;
		}
	}

	public function pageItems($slug = "")
	{
		if ($slug == "") {
			return PageItem::get();
		} else {
			return PageItem::where('slug', $slug)->get();
		}
	}
}