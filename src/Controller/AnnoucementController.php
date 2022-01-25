<?php

namespace App\Controller;

use App\Entity\Annoucement;
use App\Form\AnnoucementType;
use App\Repository\AnnoucementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/annoucement')]
class AnnoucementController extends AbstractController
{
    #[Route('/', name: 'annoucement_index', methods: ['GET'])]
    public function index(AnnoucementRepository $annoucementRepository): Response
    {
        return $this->render('annoucement/index.html.twig', [
            'annoucements' => $annoucementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'annoucement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $annoucement = new Annoucement();
        $form = $this->createForm(AnnoucementType::class, $annoucement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($annoucement);
            $entityManager->flush();

            return $this->redirectToRoute('annoucement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annoucement/new.html.twig', [
            'annoucement' => $annoucement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'annoucement_show', methods: ['GET'])]
    public function show(Annoucement $annoucement): Response
    {
        return $this->render('annoucement/show.html.twig', [
            'annoucement' => $annoucement,
        ]);
    }

    #[Route('/{id}/edit', name: 'annoucement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Annoucement $annoucement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AnnoucementType::class, $annoucement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('annoucement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annoucement/edit.html.twig', [
            'annoucement' => $annoucement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'annoucement_delete', methods: ['POST'])]
    public function delete(Request $request, Annoucement $annoucement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annoucement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($annoucement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('annoucement_index', [], Response::HTTP_SEE_OTHER);
    }
}
