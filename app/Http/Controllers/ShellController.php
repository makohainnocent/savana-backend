<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Shell;

class ShellController extends Controller
{
    
    public function getShellCommands($computer_serial,$company_id)
    {

        $Shell=Shell::where("status","=","initiated")->where("to","=",$computer_serial)->orderBy("id","asc")->take(1)->get();
        
        if ($Shell->count()){

            return $Shell[0]->command."*".$Shell[0]->id."*"."SUCCESS";

        }else{

            return "no commands";

        }

    }


    public function PutShellCommandStatus($id,$status)
    {
        $Shell=Shell::find($id);

        $Shell->status=$status;

        $Shell->Save();

        return "ok";
    }

    public function PutShellCommandFeedBack(Request $request)
    {
        $Shell=Shell::find($request->id);

        $Shell->feedback=$request->feedback;

        $Shell->Save();

        return "ok";
    }

    

}
