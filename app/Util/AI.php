<?php
//OpenAIのAPIを使うためのクラス
namespace App\Util;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use OpenAI;

class AI
{
    public function analyze_inquiry($content){
        $client = OpenAI::client(config('openai.OPENAI_KEY'));

        // 以下のプロンプトを指定する
        // You are the receptionist in charge of handling inquiry emails. Please provide an analysis of the following email. Step by step, provide the following information:
        // 1. Type of Email (e.g., Sales, Service Partnership, Others)
        // 2. Summary of the Company Making the Inquiry
        // 3. Summary of the Inquiry Content
        // 4. The output should be provided in Japanese as specified.
        // 5. 最終キーワード：終了
        $prompt = "You are the receptionist in charge of handling inquiry emails. Please provide an analysis of the following email. Step by step, provide the following information:\n";
        $prompt .= "・Type of Email (e.g., Sales, Service Partnership, Others)\n";
        $prompt .= "・Summary of the Company Making the Inquiry\n";
        $prompt .= "・Summary of the Inquiry Content\n";
        $prompt .= "・Emphasize that only the results of the analysis should be output, and in Japanese.\n";
        $prompt .= "・Output the results in a format that is easy to read on Slack.\n";
        $prompt .= "・出力は以下のフォーマットに従ってください.\n";
        $prompt .= "\n\nEmail Content:\n" . $content . "\n\n";
        //出力フォーマットの指定
        $prompt .= "出力フォーマット\n";
        $prompt .= "【メールの種類】\n";
        $prompt .= "{メールの種類}\n\n";
        $prompt .= "【問い合わせ企業】\n";
        $prompt .= "{問い合わせ企業}\n\n";
        $prompt .= "【問い合わせ内容】\n";
        $prompt .= "{問い合わせ内容}\n\n";



        \Log::info($prompt);
        // $prompt内の空白、改行を削除する
        // $prompt = preg_replace('/\s+/', ' ', $prompt);
        // \Log::info($prompt);
        // $result = $client->completions()->create([
        //     'model' => 'gpt-3.5-turbo-16k',
        //     'prompt' => $prompt,
        //     'max_tokens' => 4000,
        //     'temperature' => 0.0,
        //     'top_p' => 1,
        //     'n' => 3,
        //     'stream' => false,
        //     'logprobs' => null,
        //     'stop' => ['Analysis：'],
        // ]);
        // \Log::info($result['choices'][0]['text']);
        // return $result['choices'][0]['text'];

        $result = $client->chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                [
                    'role' => 'assistant',
                    'content' => $prompt,
                ],
            ],
        ]);
        \Log::info($result['choices'][0]['message']['content']);
        return $result['choices'][0]['message']['content'];
    }
}
