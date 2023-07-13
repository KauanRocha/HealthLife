<?php

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class EmailService
{
    /**
     * @throws TransportExceptionInterface
     */
    public function SendEmail($destiny, $subject, $text): ?Email
    {
        $dns = 'smtp://kauanrocha.professional@gmail.com:6F7D962EE7707A17EFE8216A0E5A33BC81D0@smtp.elasticemail.com:2525';
        $transport = Transport::fromDsn($dns);

        $email = (new Email())
        ->from('kauanrocha.professional@gmail.com')
        ->to($destiny)
        ->subject($subject)
        ->text($text);

        $mailer = new Mailer($transport);

        $mailer->send($email);

        return $email;
    }

}
