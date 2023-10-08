<?php

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class EmailCommon
{
    function __construct()
    {
    }

    public static function sendEmail(MailerInterface $mailer, string $from, string $to, string $subject, string $text, string $html)
    {
        $email = (new Email())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->text($text)
            ->html($html);

        $sentMessage = $mailer->send($email);

        try {
            $mailer->send($email);
            return true;
        } catch (TransportExceptionInterface $e) {
            return "Failed to send email: " . $e->getMessage();
            return false;
        }
    }
}
