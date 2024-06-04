<?php

namespace App\Http\Controllers\Admin;

use App\Events\PusherBroadcast;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{

    use ResponseTrait;

    public function index()
    {
        $userAuth = Auth::id();
        $users = User::whereNotIn('id', [$userAuth])->get();
        return view(
            'admin.chat.index',
            [
                'users' => $users,
            ]
        );
    }
    public function broadcast(Request $request, $receiver_id)
    {
        $sender_id = Auth::id();
        $receiver_id = $receiver_id;
        $message = $request->get('message');

        Chat::query()
            ->create([
                'sender_id' => $sender_id,
                'receiver_id' => $receiver_id,
                'message' => $message,
            ]);

        // phát sóng sự kiện
        broadcast(new PusherBroadcast($message, $sender_id, $receiver_id))->toOthers();
        return $request->get('message');
    }

    public function getHistory(Request $request)
    {
        $sender_id = $request->input('sender_id');
        $receiver_id = $request->input('receiver_id');
        $history = Chat::getHistory($sender_id, $receiver_id);
        return $this->successResponse($history, 'Thành công');
    }
}