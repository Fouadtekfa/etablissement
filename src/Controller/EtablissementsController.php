<?php

namespace App\Controller;
use App\Repository\ProductRepository;

use App\Entity\Etablissement;
use App\Entity\Commentaires;
use http\Message\Body;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Form\UserType;

use App\Controller\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Form\CommentairesType;


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
    #[Route('/etablissements/supprimer/{id}', name: 'etablissementsupprimer')]
    public function etablissementsup(int $id,EntityManagerInterface $em): Response
    {

        return $this->redirectToRoute('etablissement');
    }

    // ============ COMMENTAIRES =======================

        // Formulaire UPDATE
        #[Route('/etablissement/{id_et}/commentaire/update/{id}', name: 'commentaireUpdate')]
        public function commentaireUpdate(HttpFoundationRequest $request, $id_et, $id,  EntityManagerInterface $em): Response
        {
            $crud = $em->getRepository(Commentaires::class)->find($id);
            $form = $this->createForm(CommentairesType::class, $crud);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $em->persist($crud);
                $em->flush();

                return $this->redirectToRoute('etablissement', [
                    'id' => $id_et
                ]);}

            return $this->render('commentaires/updateComment.html.twig', [
                'form'=> $form->createView(),
                'etablissement'=> $id_et
            ]);
        }

    
        // Supprimer un commentaire    
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
