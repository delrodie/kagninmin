<?php

namespace App\Services;

use App\Entity\Message;
use App\Repository\CorrespondanceRepository;
use App\Repository\MessageRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactMailer
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly LoggerInterface $logger,
        private readonly CorrespondanceRepository $correspondanceRepository,
        private readonly MessageRepository $messageRepository,
        private readonly string $superAdminEmail,
    )
    {
    }

    public function notifAdmins(Message $message): void
    {
        $email = (new Email())
            ->from('no-reply@ongkagninmin.com')
            ->to(...$this->toAdresses())
            ->bcc($this->superAdminEmail)
            ->replyTo($message->getEmail())
            ->subject('[Contact] ' . $message->getObjet()->getTitre())
            ->html(sprintf(
                '<h2>Nouveau message reçu</h2>
                <p><strong>De :</strong> %s</p>
                <p><strong>Email :</strong> %s</p>
                <p><strong>Objet :</strong> %s</p>
                <hr>
                <p>%s</p>',
                htmlspecialchars($message->getNom()),
                htmlspecialchars($message->getEmail()),
                htmlspecialchars($message->getObjet()->getTitre()),
                nl2br(htmlspecialchars($message->getContenu()))
            ));

        $this->mailer->send($email);
    }

    private function toAdresses(): array
    {
        $emails = $this->correspondanceRepository->findBy(['isActif' => true]);
        if ($emails){
            foreach ($emails as $email) {
                $adresses[] = $email->getEmail();
            }
        }else{
            $adresses[] = $this->superAdminEmail;
        }


        return $adresses;
    }
}
