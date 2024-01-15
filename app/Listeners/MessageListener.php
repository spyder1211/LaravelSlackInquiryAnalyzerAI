<?php

namespace App\Listeners;

use \MeilleursBiens\LaravelSlackEvents\Events\Message;
use Illuminate\Contracts\Queue\ShouldQueue;
use \MeilleursBiens\LaravelSlackEvents\Facades\Slack;
use \JoliCode\Slack\ClientFactory;

class MessageListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Message $message)
    {
        \Log::info('New message posted, message text is: ' . $message->data['text']);
        // メッセージ送信元のスレッドを取得
        $channel = $message->data['channel'];
        // メッセージ送信元のユーザーを取得
        $user = $message->data['user'];
        // メッセージのテキストを取得
        $text = $message->data['text'];
        // tsを取得
        $ts = $message->data['ts'];

        if($user == config('slack_events.bot_user_id')){
            // メッセージ送信元のユーザーがbotの場合は処理を終了
            return;
        }
        // openai apiを叩き


        $yourSlackToken = config('slack_events.slack_auth_token');
        $client = ClientFactory::create($yourSlackToken);
        $client->chatPostMessage([
            'text' => $text,
            'channel' => $channel,
            'thread_ts' => $ts,
        ]);
    }
}
