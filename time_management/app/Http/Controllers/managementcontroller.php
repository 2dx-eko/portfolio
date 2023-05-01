<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\management;

class managementcontroller extends Controller
{
    public function index(){
        $db = new management;
        $alls = $db::all();
        return view('/management.index',compact('alls'));
    }
}
