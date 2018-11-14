<?php 

namespace Acme\Asset;

use Illuminate\Support\Collection;
use App\Asset as AssetModel;

use App\AssetGroup;
use App\AssetGroupItem;

class Asset
{
    /*
        Save Group of Assets 
        @param db = Instance of the related model
        @param data = json encoded data of the group to be created/updated
                      including it's assets
    */
    public function sync($db, $data = "")
    { 
        try {
            $groupData = json_decode($data);
        } catch(Exception $e) {}

        if (isset($groupData) && @$groupData) {
            if (@$groupData->assets) {
                try {
                    $group = [];
                    $group = $db->assetGroups()->updateOrCreate(
                                        ['id'=>$groupData->id], 
                                        ['name'=>$groupData->name]);

                    $group->assets()->delete();
                } catch(Exception $e) {}

                foreach ($groupData->assets as $key => $val) {
                    $asset = New AssetGroupItem;
                    $asset->asset_id = $val->asset_id;
                    $asset->order = $val->order;
                    $group->assets()->save($asset);
                }

                return [
                    'id' => @$group->id,
                    'header' => @$groupData->id
                ];
            }
        }

        return ['id'=>'0','header'=>'0'];
    }
}