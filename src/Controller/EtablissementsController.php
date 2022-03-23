<?php

namespace App\Controller;

use App\Entity\Etablissement;
use App\Entity\Commentaires;
use http\Message\Body;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class EtablissementsController extends AbstractController
{
    private EntityManagerInterface $em;

    #[Route('/etablissements', name: 'etablissements', methods: 'GET')]
    public function index(EntityManagerInterface $em): Response
    {
        $this->em = $em;
        $repostories = $em->getRepository(Etablissement::class)->findAll();
        $arrObj = [];
        
        foreach($repostories as $cle => $re) {
            $re->date_ouverture = $re->date_ouverture->format('d/m/Y');
        }

        return $this->render('etablissements/index.html.twig', [
            'etablissements' => $repostories
        ]);
    }

    #[Route('/etablissement/{id}', name: 'etablissement')]
    public function etablissement($id, EntityManagerInterface $em): Response
    {
        $com = $em->getRepository(Commentaires::class)->findBy([
            'etablissement'  => $id
        ]);

        foreach($com as $cle => $c) {
            $c->date_commentaire = $c->date_commentaire->format('d/m/Y');
        }
        
           return $this->render('etablissements/etablissement.html.twig', [
            'id_etablissement' => $id,
            'commentaire' => $com
        ]);
    }

    #[Route('/etablissements/departement/{id}', name: 'departement')]
    public function departement($id): Response
    {
        return $this->render('etablissements/departement.html.twig', [
            'code_departement' => $id,
        ]);
    }
    #[Route('/etablissements/region/{id}', name: 'region')]
    public function region($id): Response
    {
        return $this->render('etablissements/region.html.twig', [
            'code_region' => $id,
        ]);
    }
    #[Route('/etablissements/academie/{id}', name: 'academie')]
    public function academie($id): Response
    {
        return $this->render('etablissements/academie.html.twig', [
            'code_academie' => $id,
        ]);
    }
    #[Route('/etablissements/commune/{id}', name: 'commune')]
    public function commune($id): Response
    {
        return $this->render('etablissements/commune.html.twig', [
            'code_commune' => $id,
        ]);
    }

    // ============ COMMENTAIRES =======================
    #[Route('/etablissement/{id_et}/commentaire/supprimer/{id}', name: 'commentaireSupprimer')]
    public function commentaireSupprimer($id_et, $id,  EntityManagerInterface $em): Response
    {
        $com = $em->getRepository(Commentaires::class)->findOneBy([
            'id'  => $id
        ]);
        
        $em->remove($com);
        $em->flush();
        return $this->redirectToRoute('etablissement', [
            'id' => $id_et
        ]);
    }

    #[Route('/commentaire/modifier/{id}', name: 'commentaireModifier')]
    public function commentaireModifier($id): Response
    {
        return $this->render('/commune.html.twig', [
            'code_commune' => $id,
        ]);
    }

}
