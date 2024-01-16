<?php

namespace App\Jobs;

use App\Util\AI;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use \JoliCode\Slack\ClientFactory;

class AnalyzeInquiry implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // 任意のプロパティを定義
    protected $data;

    /**
     * Create a new job instance.
     *
     * @param mixed $data ジョブに渡すデータ
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // ここに時間のかかる処理を実装
        $openai = new AI();
        $response = $openai->analyze_inquiry($this->data['text']);

        $yourSlackToken = config('slack_events.slack_auth_token');
        $client = ClientFactory::create($yourSlackToken);
        $client->chatPostMessage([
            'text' => $response,
            'channel' => $this->data['channel'],
            'thread_ts' => $this->data['ts'],
        ]);
    }
}
