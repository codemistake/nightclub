<?php

namespace App\Core\Mail\Request;

/**
 * Class MessageDto
 *
 * @package App\Core\Mail\SwiftMailer
 */
class Mail
{
    /** @var string */
    private $from;
    /** @var array */
    private $to;
    /** @var string|null */
    private $replyTo;
    /** @var string|null */
    private $subject;
    /** @var string */
    private $messageBody;

    /**
     * Mail constructor.
     *
     * @param MessageBuilder $messageBuilder
     */
    public function __construct(MessageBuilder $messageBuilder)
    {
        $this->from = $messageBuilder->getFrom();
        $this->to = $messageBuilder->getTo();
        $this->replyTo = $messageBuilder->getReplyTo() ?? null;
        $this->subject = $messageBuilder->getSubject() ?? null;
        $this->messageBody = $messageBuilder->getMessageBody();
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @return array
     */
    public function getTo(): array
    {
        return $this->to;
    }

    /**
     * @return null|string
     */
    public function getReplyTo(): ?string
    {
        return $this->replyTo;
    }

    /**
     * @return null|string
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getMessageBody(): string
    {
        return $this->messageBody;
    }
}