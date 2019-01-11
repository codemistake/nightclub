<?php

namespace App\Core\Mail;

use App\Core\Mail\Request\Mail;
use App\Core\Mail\Exception\RecoverableMailException;

/**
 * Interface MailClientInterface
 *
 * @package App\Core\Mail
 */
interface MailClientInterface
{
    /**
     * @param Mail $messageMail
     *
     * @return bool
     * @throws RecoverableMailException
     */
    public function sendMail(Mail $messageMail): bool;
}
