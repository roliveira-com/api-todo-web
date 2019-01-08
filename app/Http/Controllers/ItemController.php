<?php namespace App\Http\Controllers;

use JWTAuth;
use App\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    /**
    * Cria uma nova tarefa na base
    *
    * @return mixed
    */
    public function postItem(Request $request)
    {

      $user = JWTAuth::parseToken()->toUser();
      
      $request_valid = $request->validate([
        'title' => 'required',
        'list'  => 'required',
      ]);

      $item = new Item();
      $item->title        = $request->input('title');
      $item->user         = $user->id;
      $item->list         = $request->input('list');
      $item->description  = $request->input('description');
      $item->due          = $request->input('due');
      $item->progress     = $request->input('progress');
      $item->done         = $request->input('done');
      $item->save();
      return response()->json(['error'=>false,'result'=>'OK','operation'=>'item_added','item'=>$item], 201);
    }

    /**
    * Retorna uma lista de todas as tarefas cadastradas
    *
    * @return mixed
    */
    public function getItem()
    {
      $item = Item::all();
      $response = [
        'items' => $item
      ];
      return response()->json(['error'=>false,'result'=>$response,'operation'=>'get_items'], 200);
    }

    /**
    * Edita uma tarefa cadastrada
    *
    * @param id 
    * @return mixed
    */
    public function editItem(Request $request, $id)
    {
      $item = Item::find($id);
      if(!$item){
        return response()->json(['error'=>true,'result'=>'no post found', 'operation'=>'edit_item'], 200);
      }
      $item->title        = $request->input('title');
      $item->user         = $request->input('user');
      $item->list         = $request->input('list');
      $item->description  = $request->input('description');
      $item->due          = $request->input('due');
      $item->progress     = $request->input('progress');
      $item->done         = $request->input('done');
      $item->update();
      return response()->json(['error'=>false,'result'=>'OK','operation'=>'edit_item','item'=>$item], 200);
    }

    /**
    * Deleta uma tarefa criada
    *
    * @param id
    * @return mixed
    */
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