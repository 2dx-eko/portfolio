<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\listtodo;

class listparent extends Model
{
    protected $table = 'listparent';
    
    //リスト作成
    public static function listCreate($id,$text){
        listparent::insert([
            'user-id' => $id,
            'list-title' => $text,
        ]);
    }


    public static function getList($id){
        $query = listparent::where('user-id',$id)->get();
        return $query;
    }

    //where id only
    public static function userGetId($loginflg_session){
        $query = users::where('id',$loginflg_session)->get();
        return $query;
    }
    
    public static function listDelete($userid,$parentid){
        listparent::where('id',$parentid)->where('user-id',$userid)->delete();
        listtodo::where('listparent-id',$parentid)->where('user-id',$userid)->delete();
    }

}
