<?php

namespace App\Controller;

use http\Message\Body;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtablissementsController extends AbstractController
{
    #[Route('/etablissements', name: 'etablissements', methods: 'GET')]
    public function index(): Response
    {
        $etablissements = [
            [
                "id" => 1,
                "appellation_officielle" => "CAO",
                "denomination_principale" => "Denom",
                "secteur" => "Agricole",
                "latitude" => "23,405",
                "longitude" => "39,56",
                "adresse" => "Le havre",
                "departement" => "Seine Maritime",
                "commune" => "Jsp",
                "region" => "Normandie",   
                "academie" => "Normand",
                "date_ouverture" => "22/02/2022"   
            ],
            [
                "id" => 2,
                "appellation_officielle" => "FGH",
                "denomination_principale" => "Denom2",
                "secteur" => "Aviateur",
                "latitude" => "35,405",
                "longitude" => "86,46",
                "adresse" => "Caen",
                "departement" => "Calvados",
                "commune" => "com",
                "region" => "Normandie",   
                "academie" => "Mont",
                "date_ouverture" => "10/01/2020"   
            ]
        ];

        return $this->render('etablissements/index.html.twig', [
            'etablissements' => $etablissements
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
