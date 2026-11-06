<?php

namespace App\Controller;

use App\Contact\ContactData;
use App\Contact\ContactHandler;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{

    #[Route('/', name: 'app_homepage', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('main/index.html.twig');
    }

    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function contact(Request $request, ContactHandler $contactHandler): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                $this->addFlash('success', 'Votre message a bien été envoyé.');
                $contactHandler->handle($form->getData());
                return $this->redirectToRoute('app_homepage');
        }

        return $this->render('main/contact.html.twig', [
            'contact_form' => $form,
        ]);
    }
}
