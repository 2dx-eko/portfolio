<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class listtodo extends Model
{
    protected $table = 'listtodo';
    public $timestamps = false;

    //todo作成
    public static function todoCreate($list_parentId,$userid,$todo_create){
        listtodo::insert([
            'listparent-id' => $list_parentId,
            'user-id' => $userid,
            'content' => $todo_create,
            'created_at' => NOW(),
        ]);
    }

    public static function getTodo($parameter_userid){
        $query = listtodo::where('user-id',$parameter_userid)->get();
        return $query;
    }
    
    public static function getTodoPart($todo_id,$listparent_id,$userid){
        $query = listtodo::where('id',$todo_id)->where('listparent-id',$listparent_id)->where('user-id',$userid)->get();
        return $query;
    }

    public static function todoDelete($todo_id,$listparent_id,$userid){
        $query = listtodo::where('id',$todo_id)->where('listparent-id',$listparent_id)->where('user-id',$userid)->delete();
    }

    public static function listBold($todo_id,$listparent_id,$userid){ //bold
        $query = listtodo::where('id',$todo_id)->where('listparent-id',$listparent_id)->where('user-id',$userid)->update(['bold-flg' => true]);
    }
    public static function listBoldFalse($todo_id,$listparent_id,$userid){ //bold解除
        $query = listtodo::where('id',$todo_id)->where('listparent-id',$listparent_id)->where('user-id',$userid)->update(['bold-flg' => false]);
    }


}
