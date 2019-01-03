<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ItemController extends BaseController
{
    public function postItem(Request $request)
    {
      $item = new Item();
      $item->item_name = $request->input('itemName');
      $item->user_id = $request->input('itemUser');
      $item->list_id   = $request->input('itemList');
      $item->save();
      return response()->json(['error'=>false,'result'=>'OK','operation'=>'item_added','item'=>$item], 201);
    }

    public function getItem()
    {
      $item = Item::all();
      $response = [
        'items' => $item
      ];
      return response()->json(['error'=>false,'result'=>$response,'operation'=>'get_items'], 200);
    }

    public function editItem(Request $request, $id)
    {
      $item = Item::find($id);
      if(!$item){
        return response()->json(['error'=>true,'result'=>'no post found', 'operation'=>'edit_item'], 200);
      }
      $item->item_name = $request->input('itemName');
      $item->save();
      return response()->json(['error'=>false,'result'=>'OK','operation'=>'edit_item','item'=>$item], 200);
    }

    public function deleteItem(Request $request, $id)
    {
      $item = Item::find($id);
      if(!$item){
        return response()->json(['error'=>true,'result'=>'no item found to delete', 'operation'=>'delete_item'], 200);
      }
      $item->delete();
      return response()->json(['error'=>false,'result'=>'OK','operation'=>'delete_item','item'=>$item], 200);
    }
}