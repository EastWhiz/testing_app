<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SocketController extends Controller{
    function __construct(){

    }

    function SaveSocket(){
        $r = DB::table("options")->where("option_key", "socket")->first();
        $d = array(
            "drop1" => request("drop1"),
            "drop2" => request("drop2")
        );
        $data = array(
            "option_key" => "socket",
            "option_value" => json_encode($d)
        );
        if (isset($r->id)){
            DB::table("options")->where("option_key", "socket")->update($data);
        }else{
            DB::table("options")->insert($data);
        }
    }
    function GetSocket(){
        $r = DB::table("options")->where("option_key", "socket")->first();
        $data = array(
            "drop1" => "",
            "drop2" => ""
        );
        if (isset($r->id)){
            $d = json_decode($r->option_value, true);
            $data = array(
                "drop1" => $d["drop1"],
                "drop2" => $d["drop2"]
            );
        }
        return $data;
    }
} 

