<?php

namespace App\Core\Mail;

use App\Core\Mail\Exception\MailException;
use App\Core\Mail\Exception\RecoverableMailException;
use App\Core\Mail\Request\Mail;

/**
 * Class SwiftMailerMailClient
 *
 * @package App\Core\Mail
 */
class SwiftMailerMailClient implements MailClientInterface
{

    /**
     * @var \Swift_Mailer
     */
    private $swiftMailer;

    /**
     * SwiftMailerMailClient constructor.
     *
     * @param string $host
     * @param int $port
     * @param string $login
     * @param string $password
     */
    public function __construct(string $host, int $port, ?string $login, ?string $password)
    {
        $transport = new \Swift_SmtpTransport($host, $port);
        if ($login) {
            $transport->setUsername($login);
        }
        if ($password) {
            $transport->setPassword($password);
        }
        $this->swiftMailer = new \Swift_Mailer($transport);
    }

    /**
     * @param Mail $messageMail
     * @return bool
     * @throws RecoverableMailException
     */
    public function sendMail(Mail $messageMail): bool
    {
        $this->checkClientForReadyToSentEmail();
        try {
            $mail = new \Swift_Message();
            $mail->setFrom($messageMail->getFrom());
            $mail->setReplyTo($messageMail->getTo());
            $mail->setTo($messageMail->getTo());
            $mail->setSubject($messageMail->getSubject());
            $mail->setBody($messageMail->getMessageBody());
            $mail->setContentType('text/html');
            $countSuccessEmails = $this->swiftMailer->send($mail);
            if ($countSuccessEmails === 0) {
                throw new MailException('Can\'t deliver email to' . $messageMail->getTo());
            }
        } catch (\Throwable $exception) {
            throw new MailException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        } finally {
            $this->swiftMailer->getTransport()->stop();
        }

        return true;
    }

    /**
     * @throws RecoverableMailException
     */
    private function checkClientForReadyToSentEmail(): void
    {
        if (
            $this->swiftMailer->getTransport()->isStarted() === false
            ||
            $this->swiftMailer->getTransport()->ping() === false
        ) {
            try {
                $this->swiftMailer->getTransport()->start();
            } catch (\Throwable $e) {
                throw new RecoverableMailException('Can\'t connect to mail service');
            }
        }
    }
}
