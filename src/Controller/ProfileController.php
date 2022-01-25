<?php

namespace App\Controller;

use App\Form\SiretType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{

    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    
    #[Route('/profile', name: 'profile')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    #[Route('/siret', name: 'add_siret')]
    public function addSiret(Request $request, EntityManagerInterface $entityManager): Response
    {
        $profile = $this->getUser();
        $form = $this->createForm(SiretType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $siret = $form->getData()->getSiret();

            if (!empty($siret)) {
                $response = $this->client->request(
                    'GET',
                    "https://entreprise.data.gouv.fr/api/sirene/v1/siret/$siret"
                );
            }
            
            if (!empty($response)) {
                $responseContent = json_decode($response->getContent());
                $profile->setCity($responseContent->etablissement->libelle_commune);
                $profile->setCompanyName($responseContent->etablissement->l1_normalisee);
            }else {
                throw new \Exception('incorrect SIRET number !');
            }
            $entityManager->flush();

            return $this->redirectToRoute('profile', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('profile/addSiret.html.twig', [
            'profile' => $profile,
            'form' => $form->createView(),
        ]);
    }
}
