<?php

namespace App\Controller;
use App\Form\EtablissementType;
use App\Repository\CommentairesRepository;
use App\Repository\EtablissementRepository;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Config\DoctrineConfig;
use App\Repository\ProductRepository;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

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
    #[Route('/etablissements/{id_et}/commune/{id}', name: 'commune')]
    public function commune($id_et, $id, EntityManagerInterface $em): Response
    {
        /*$etab = $em->getRepository(Etablissement::class)->findOneBy([
            'id'  => $id_et
        ]);*/

        $et = $em->getRepository(Etablissement::class)->findBy([
            'id'  => $id_et
        ]);


        return $this->render('etablissements/commune.html.twig', [
            'code_commune' => $id,
            'etablissement' => $et
        ]);
    }
    #[Route('/etablissements/supprimer/{id}', name: 'etablissementsupprimer')]
    public function etablissementsup($id , EntityManagerInterface $em): Response
    {
        $com = $em->getRepository(Etablissement::class)->findOneBy([
            'id'  => $id
        ]);

        $em->remove($com);
        $em->flush();
        return $this->redirectToRoute('etablissements');
    }
    // Formulaire ADD
    #[Route('/etablissements/create', name: 'etablissementCreate')]
    public function etablissementCreate(HttpFoundationRequest $request,  EntityManagerInterface $em): Response
    {
        $etablissement = new Etablissement();
        $etablissement->setDateOuverture(new \DateTime());
        $form = $this->createFormBuilder($etablissement)
               ->add('appellation_officielle')
                ->add('denomination_principale')
                ->add('secteur')
                ->add('latitude',IntegerType::class, ['label'=>'Latitude', 'attr'=>['min'=> -90, 'max'=>90, 'step'=>0.1]] )
                ->add('longitude',IntegerType::class, ['label'=>'Longitude', 'attr'=>['min'=>0, 'max'=>180, 'step'=>0.1]])
                ->add('adresse')
                ->add('departement')
                ->add('code_departement')
                ->add('commune')
                ->add('code_commune')
                ->add('region')
                ->add('code_region')
                ->add('academie')
                ->add('code_academie')
                ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em->persist($etablissement);
            $em->flush();
            return $this->redirectToRoute('etablissements');

        }
        return $this->render('etablissements/createEtablissement.html.twig', [
            'form'=> $form->createView(),

        ]);




    }



  /*  #[Route('/etablissement/update/{id}', name: 'etablissementUpdate')]
    public function commentaireUpdate(HttpFoundationRequest $request, $id,  EntityManagerInterface $em): Response
    {
        $crud = $em->getRepository(Commentaires::class)->find($id);
        $form = $this->createForm(EtablissementType::class, $crud);

        $crud->setDateCommentaire(new \DateTime());
        $form = $this->createFormBuilder($crud)
            ->add('auteur')
            ->add('commentaire')
            ->add('note')
            ->getForm();

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

*/
    // ============ COMMENTAIRES =======================

        // Formulaire UPDATE
        #[Route('/etablissement/{id_et}/commentaire/update/{id}', name: 'commentaireUpdate')]
        public function commentaireUpdate(HttpFoundationRequest $request, $id_et, $id,  EntityManagerInterface $em): Response
        {
            $crud = $em->getRepository(Commentaires::class)->find($id);
            $form = $this->createForm(CommentairesType::class, $crud);
            
            $crud->setDateCommentaire(new \DateTime());
            $form = $this->createFormBuilder($crud)
                ->add('auteur')
                ->add('commentaire')
                ->add('note')
                ->getForm();
            
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

        // Formulaire ADD
        #[Route('/etablissement/{id_et}/commentaire/create', name: 'commentaireCreate')]
        public function commentaireCreate(HttpFoundationRequest $request, $id_et,  EntityManagerInterface $em): Response
        {
            $crud = new Commentaires();
            $etab = $em->getRepository(Etablissement::class)->findOneBy([
                'id'  => $id_et
            ]);
            $crud->setEtablissement($etab);
            $crud->setDateCommentaire(new \DateTime());
            $form = $this->createFormBuilder($crud)
                ->add('auteur')
                //->add('date_commentaire')
                ->add('commentaire')
                ->add('note')
                //->setMethod("GET")
                ->getForm();

            //$form = $this->createForm(CommentairesType::class, $crud);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $em->persist($crud);
                $em->flush();

                return $this->redirectToRoute('etablissement', [
                    'id' => $id_et
                ]);}

            return $this->render('commentaires/createComment.html.twig', [
                'form'=> $form->createView(),
                'id_etablissement' => $id_et
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
