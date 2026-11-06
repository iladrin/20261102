<?php

namespace App\Contact;

use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\MailerInterface;

readonly class ContactHandler
{

    public function __construct(
        private LoggerInterface $logger,
        private MailerInterface $mailer,
        #[Autowire(param: 'email.contact')] private string $contactEmail
    )
    {
    }

    public function handle(ContactData $data): void
    {
        $email = new TemplatedEmail()
            ->from($data->email)
            ->to($this->contactEmail)
            ->subject($data->subject)
            ->htmlTemplate('emails/contact.html.twig')
            ->context([
                'name' => $data->name,
                'from' => $data->email,
                'subject' => $data->subject,
                'message' => $data->message,
            ]);

        $this->logger->info('Contact form submitted');
        $this->mailer->send($email);

    }
}
