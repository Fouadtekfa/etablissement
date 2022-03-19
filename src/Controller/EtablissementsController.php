<?php

namespace App\Controller;

use http\Message\Body;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtablissementsController extends AbstractController
{
    #[Route('/etablissements', name: 'app_etablissements')]
    public function index(): Response
    {


        return $this->render('etablissements/index.html.twig', [
            'controller_name' => 'EtablissementsController',
        ]);
    }

}
