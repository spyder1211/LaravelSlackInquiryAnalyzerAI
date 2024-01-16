<?php

namespace App\Listeners;

use App\Jobs\AnalyzeInquiry;
use App\Models\Message;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use \MeilleursBiens\LaravelSlackEvents\Events\Message as MessageSlack;

class MessageListener implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     */
    public function handle(MessageSlack $messageSlack)
    {
        \Log::info('Listener, message text is: ' . $messageSlack->data['text']);
        $user = $messageSlack->data['bot_id'];
        if ($user != config('slack_events.bot_user_id')) {
            // メッセージ送信元のユーザーがbot以外の場合は処理を終了
            return response()->json(['ok' => true], 200);
        } else {
            // client_msg_idをDB存在するかチェックする。
            $client_msg_id = $messageSlack->data['ts'];
            $message = Message::where('client_msg_id', $client_msg_id)->first();
            if ($message) {
                // すでにDBに存在する場合は200 OKを返して処理を終了
                return response()->json(['ok' => true], 200);
            } else {
                // DBに存在しない場合はDBに保存する
                $message = new Message();
                $message->client_msg_id = $client_msg_id;
                $message->save();
                $data = $messageSlack->data;
                AnalyzeInquiry::dispatch($data);
                return response()->json(['ok' => true], 200);
            }
        }
    }
}
