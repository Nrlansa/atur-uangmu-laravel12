<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WhatsappController extends Controller
{
    public function index(Request $request){
        
        return view('whatsapp');
    }
    public function send(Request $request)
    {
        $phone = env('WHATSAPP_NUMBER');
        $text = __("messages.wa_wa_hello") . " *{$request->name}*." . "\n\n" .
            "*" . __("messages.wa_wa_message_label") . ":* " . "\n" .
            "_{$request->message}_";
        return redirect()->away("https://api.whatsapp.com/send?phone=$phone&text=" . urlencode($text));
    }
}
