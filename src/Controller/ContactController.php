<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\CoordonneeRepository;
use App\Repository\ObjetRepository;
use App\Services\ContactMailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/contact')]
class ContactController extends AbstractController
{
    public function __construct(
        private CoordonneeRepository $coordonneeRepository,
        private ObjetRepository $objetRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly ContactMailer $contactMailer
    )
    {
    }

    #[Route('/', name:'app_contact_index')]
    public function index(Request $request): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($message);
            $this->entityManager->flush();

            try {
                $this->contactMailer->notifAdmins($message);
                sweetalert()->success("Votre message a été enregistré et envoyé avec succès aux administrateurs!");
            }catch (\Exception $e){
                sweetalert()->warning("Votre message a été enregistré avec succès. Cependant le mail n'a pu être envoyé aux administrateurs");
            }

            return $this->redirectToRoute('app_contact_index');
        }

        return $this->render('frontend/contact.html.twig',[
            'coordonnee' => $this->coordonneeRepository->findOneBy([],['id' => 'DESC']),
            'objets' => $this->objetRepository->findBy(['isActif' => true]),
            'form' => $form,
            'message' => $message
        ]);
    }

    #[Route('/{slug}', name: '')]
    public function widget($slug)
    {

    }

    #[Route('/footer', name: 'app_contact_footer')]
    public function footer()
    {
        return $this->render('frontend/_contact_footer.html.twig',[
            'coordonnee' => $this->coordonneeRepository->findOneBy([],['id' => "DESC"])
        ]);
    }
}
