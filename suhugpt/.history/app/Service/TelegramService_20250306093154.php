<?php

namespace App\Service;
use illuminate\Support\Facades\Http;

class TelegramService{
    protected $token;
    protected $chatId;

    public function __construct(){
        $this->token = env('TELEGRAM_BOT_TOKEN');
        $this->chatId = env('TELEGRAM_CHAT_ID');
    }


    public function sendMessage($message){
        $url = "https://api.telegram.org/bot{$this->token}/sendMessage";

        return Http::post($url,[
            'chat_id' => $this->chatId,
            'text' => $message
        ]);


    }


}
