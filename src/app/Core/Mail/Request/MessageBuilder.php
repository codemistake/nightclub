<?php

namespace App\Core\Mail\Request;

use App\Core\Mail\Exception\MailException;

/**
 * Class MessageBuilder
 *
 * @package App\Core\Mail\Request
 */
class MessageBuilder
{
    /** @var string */
    private $from;
    /** @var array */
    private $to = [];
    /** @var string|null */
    private $replyTo;
    /** @var string|null */
    private $subject;
    /** @var string */
    private $messageBody;

    /**
     * @return Mail
     */
    public function build(): Mail
    {
        try {
            return new Mail($this);
        } catch (MailException $e) {
            throw new MailException('Incorrect Mail params');
        }
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @param string $from
     *
     * @return MessageBuilder
     */
    public function from(string $from): MessageBuilder
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return array
     */
    public function getTo(): array
    {
        return $this->to;
    }

    /**
     * @param string $to
     *
     * @return MessageBuilder
     */
    public function addTo(string $to): MessageBuilder
    {
        $this->to[] = $to;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReplyTo(): ?string
    {
        return $this->replyTo;
    }

    /**
     * @param string $replyTo
     *
     * @return MessageBuilder
     */
    public function replyTo(string $replyTo): MessageBuilder
    {
        $this->replyTo = $replyTo;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @param null|string $subject
     *
     * @return MessageBuilder
     */
    public function subject(?string $subject): MessageBuilder
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessageBody(): string
    {
        return $this->messageBody;
    }

    /**
     * @param string $messageBody
     *
     * @return MessageBuilder
     */
    public function messageBody(string $messageBody): MessageBuilder
    {
        $this->messageBody = $messageBody;
        return $this;
    }
}