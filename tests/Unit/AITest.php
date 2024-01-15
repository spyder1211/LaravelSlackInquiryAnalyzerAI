<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Util\AI;

class AITest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $ai = new AI();

        $this->assertNotNull($ai);

        $inquiryEmail = "
        件名: 新製品に関するお問い合わせ

        お世話になっております。株式会社サンプルテックの田中と申します。
        貴社のウェブサイトで最近発表された新製品について、詳細な情報をお願いしたいと考えております。

        特に、製品の仕様、価格、納期について詳しく知りたいと思っています。
        また、量産体制やカスタマイズオプションについても情報があれば教えてください。

        弊社では近い将来、関連するプロジェクトを計画しており、貴社の製品が非常に興味深いです。
        何卒、詳細な情報をいただけますと幸いです。

        ご多忙のところ恐縮ですが、お早めのご回答をお待ちしております。

        敬具

        株式会社サンプルテック
        営業部 部長 田中太郎
        Email: tanaka@example.com
        電話: 03-1234-5678
    ";

        $ai->analyze_inquiry($inquiryEmail);
    }
}
