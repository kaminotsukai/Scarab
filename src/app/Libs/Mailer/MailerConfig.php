<?php

declare(strict_types=1);

namespace App\Libs\Mailer;

/**
 * メール送信情報を保持するクラス
 * @package App\Libs\Mailer
 */
class MailerConfig
{
    /**
     * @var string Fromアドレス
     */
    private string $fromAddress;

    /**
     * @var string From名(sender)
     */
    private string $fromName;

    /**
     * @var array Toアドレス
     */
    private array $to = [];

    /**
     * @var string メール本文
     */
    private string $body;

    /**
     * @var string メールタイトル
     */
    private string $subject;

    /**
     * MailerConfig constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getFromAddress(): string
    {
        return $this->fromAddress;
    }

    /**
     * @param string $fromAddress
     */
    public function setFromAddress(string $fromAddress): void
    {
        $this->fromAddress = $fromAddress;
    }

    /**
     * @return string
     */
    public function getFromName(): string
    {
        return $this->fromName;
    }

    /**
     * @param string $fromName
     */
    public function setFromName(string $fromName): void
    {
        $this->fromName = $fromName;
    }

    /**
     * @return array
     */
    public function getTo(): array
    {
        return $this->to;
    }

    /**
     * @param array $to
     */
    public function setTo(array $to): void
    {
        $this->to = $to;
    }

    /**
     * @param string $to
     */
    public function addTo(string $to): void
    {
        $this->to[] = $to;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

}
