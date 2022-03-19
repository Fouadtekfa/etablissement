<?php

namespace App\Controller;

use http\Message\Body;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtablissementsController extends AbstractController
{
    #[Route('/etablissements', name: 'app_etablissements', methods: 'GET')]
    public function index(): Response
    {
        return $this->render('etablissements/index.html.twig', [
            'controller_name' => 'EtablissementsController',
        ]);
    }

    #[Route('/etablissement/{id}', name: 'etablissement')]
    public function etablissement($id): Response
    {
        return $this->render('etablissements/etablissement.html.twig', [
            'id_etablissement' => $id,
        ]);
    }

}
