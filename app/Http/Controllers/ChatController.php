<?php

namespace App\Http\Controllers;
use App\Events\ChatStoredEvent;

use Illuminate\Http\Request;
use App\Chat;
class ChatController extends Controller
{

	public function __construct()
	{
		return $this->middleware('auth');
	}
	public function store(Request $request)
	{
		$chat=Chat::create([
			'subject'=>$request->subject,
			'user_id'=>auth()->user()->id

		]);
		broadcast(new ChatStoredEvent($chat))->toOthers();
		return $chat;
	}
    public function all_chats(){
    	return Chat::with('user')->orderBy('created_at','desc')->get();
    }
}
