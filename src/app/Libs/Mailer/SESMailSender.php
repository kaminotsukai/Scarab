<?php declare(strict_types = 1);

namespace App\Libs\Mailer;

/**
 * SwiftMailerを使ったメール送信クラス
 * @package App\Libs\Mailer
 */
class SESMailSender implements MailerInterface
{
    /**
     * SwiftMailSender constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * メール送信する
     * @param MailerConfig $mailerConfig
     * @return int|mixed
     */
    public function send(MailerConfig $mailerConfig)
    {
        // 現時点ではメール送信処理は実装していません。
        return $mailerConfig;
    }
}
