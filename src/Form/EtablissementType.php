<?php

namespace App\Form;

use App\Entity\Etablissement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtablissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('appellation_officielle')
            ->add('denomination_principale')
            ->add('secteur')
            ->add('latitude')
            ->add('longitude')
            ->add('adresse')
            ->add('departement')
            ->add('code_departement')
            ->add('commune')
            ->add('code_commune')
            ->add('region')
            ->add('code_region')
            ->add('academie')
            ->add('code_academie')
            ->add('date_ouverture')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etablissement::class,
        ]);
    }
}
