<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Message;

class MessagesController extends Controller
{
    public function putMessage(Request $request){

        $Message=new Message;
        $Message->to=$request->to;
        $Message->from=$request->from;
        $Message->message=$request->message;
        $Message->attachements=$request->attachements;
        $Message->sdp=$request->sdp;
        $Message->ice=$request->ice;
        $Message->text=$request->text;
        $Message->read=$request->read;
        $Message->files=$request->get('files');
        $Message->mediaStreamType=$request->mediaStreamType;
        $Message->Save();
        if ($Message->count()){

            return 'ok';

        }else{

            return "an error occurred";

        }
    }

    public function getMessage(Request $request){
        $for=$request->for;

        $Message=Message::where("read","=","0")->where("to","=",$for)->orderBy("id","asc")->take(1)->get();
        
        if ($Message->count()){
            /* changing read status of the message*/
            $id=$Message[0]->id;

            $Message2=Message::find($id);

            $Message2->read=1;

            $Message2->Save();
            /* end of changing read status of message*/

            return $Message;

        }else{

            return "no messages";

        }
    }
}
