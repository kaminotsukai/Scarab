<?php

declare(strict_types=1);

namespace App\Libs\Mailer;

/**
 * メール送信クラスのための共通インターフェース
 * @package App\Libs\Mailer
 */
interface MailerInterface
{
    /**
     * メール送信を行う
     * @param MailerConfig $mailerConfig 送信メールの宛先、本文などの情報
     */
    public function send(MailerConfig $mailerConfig);
}
