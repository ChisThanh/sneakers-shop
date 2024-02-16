<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function send(Request $request)
    {
        Mail::send('mail.index', ['name' => 'thanh'], function ($message) {
            $message->from('chithanh18042003@gmail.com', 'Chis Thanh');
            $message->to('chithanh18042003@gmail.com', 'Chis Thanh');
            $message->subject('Sneaker Shop');
        });
        return redirect("/");
    }
}
