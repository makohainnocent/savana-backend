<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Command;

class CommandController extends Controller
{   
    //gets a command that has been dirrected to a given computer
    public function getCommands($computer_serial,$company_id)
    {
        
        $command=Command::where("status","=","initiated")->where("to","=",$computer_serial)->orderBy("id","asc")->take(1)->get();
        
        if ($command->count()){

            return $command[0]->command."*".$command[0]->id."*"."SUCCESS";

        }else{

            return "no commands";

        }
        
       

    }

    //updates the status of a command
    public function PutCommandStatus($id,$status)
    {
        $Command=Command::find($id);

        $Command->status=$status;

        $Command->Save();

        return "ok";
    }
    
    //updates the feedback message after executing a command 
    public function PutCommandFeedBack(Request $request)
    {
        $Command=Command::find($request->id);

        $Command->feedback=$request->feedback;

        $Command->Save();

        return "ok";
    }
    
    //stores a file to the server
    public function putFile(Request $request)
    {
        if($request->hasFile('file')){

            $path=$request->file->storePublicly("uploaded_files");

            return $path;

        }else{

            return "error uploading file";
        }
    }
    
    //dirrects  a  command to a given computer or initiates command
    public function createCommand($computer_serial,$userId,$command)
    {

        $command=Command::create([
            'to'=>$computer_serial,
            'from'=>$userId,
            'status'=>'initiated',
            'command'=>$command,
            'feedBack'=>'',
        ]);

        if ($command->count()){

            return 'ok';

        }else{

            return "an error occurred";

        }


    }

    public function getCommandDetails(Request $request){

        $Command=Command::find($request->commandId);

        if ($Command->count()){

            return $Command;

        }else{

            return "an error occurred";

        }
    }

    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
