<?php

namespace App\DataFixtures;

use App\Entity\Etablissement;
use App\Entity\Commentaires;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{

    /**
     * @Assert\DateTime
     * @var string A "d/m/Y" formatted value
    */
    public $date;


    public function load(ObjectManager $manager): void
    {
        $filename = 'src/DataFixtures/etablissements.csv';

        $donnees = [];

        $i = 0;
        if (($h = fopen((string)($filename), 'r')) !== FALSE) {
            while (($data = fgetcsv($h, 100000, "*")) !== FALSE) {
                if($i>1) $donnees[] = $data;
                $i++;
            }
            fclose($h);
        }
        $faker = Faker\Factory::create('fr_FR');
        $commentaires=[];
        //for ($i = 0; $i < 100; $i++) {
        //}
        $i = 0;
        $n = 0;
        foreach($donnees as $donnee) {
                $i++;
                $d = $donnee[0];
                $data = explode(";", $d);
                $etablissement = new Etablissement();
                $etablissement->setId($i);
                $etablissement->setAppellationOfficielle($data[1]);
                $etablissement->setDenominationPrincipale($data[2]);
                $etablissement->setSecteur($data[4]);
                $etablissement->setLatitude(floatval($data[14]));
                $etablissement->setLongitude(floatval($data[15]));
                $etablissement->setAdresse($data[5]);
                $etablissement->setDepartement($data[26]);
                $etablissement->setCodeDepartement($data[22]);

                $etablissement->setCommune($data[10]);
                $etablissement->setCodeCommune($data[25]);
                
                $etablissement->setRegion($data[27]);
                $etablissement->setCodeRegion($data[23]);

                $etablissement->setAcademie($data[28]);
                $etablissement->setCodeAcademie($data[24]);

                $etablissement->date_ouverture = \DateTime::createFromFormat('j/m/Y', $data[34]);
               // $etablissement->addCommentaire($commentaires[$i]);
                /*print("Appelation : " .$etablissement->getAppellationOfficielle(). PHP_EOL);
                print("Denomination : " .$etablissement->getDenominationPrincipale(). PHP_EOL);
                print("Secteur : " .$etablissement->getSecteur(). PHP_EOL);
                print("Latitude : " .$etablissement->getLatitude(). PHP_EOL);
                print("Longitude : " .$etablissement->getLongitude(). PHP_EOL);
                print("Addresse : " .$etablissement->getAdresse(). PHP_EOL);
                print("Departement : " .$etablissement->getDepartement(). PHP_EOL);
                print("Commune : " .$etablissement->getCommune(). PHP_EOL);
                print("Region : " .$etablissement->getRegion(). PHP_EOL);
                print("Academie : " .$etablissement->getAcademie(). PHP_EOL);
                print("Date : " .$etablissement->getDateOuverture(). PHP_EOL);*/
                $manager->persist($etablissement);
                //print( PHP_EOL .  PHP_EOL);
                $lim  = $faker->numberBetween(1,4);
                for($i= 0; $i <= $lim ; $i++){
                    $commentaire = new Commentaires();
                    $commentaire->setAuteur($faker->lastName);
                    $commentaire->setCommentaire($faker->realText(200));
                    $commentaire->setNote($faker->numberBetween(0,4));
                    $commentaire->setDateCommentaire(new \DateTime());
                    // $etablissement->setEtablissement($etablissement[$faker->numberBetween(0,90)]);
                    $lim  = $faker->numberBetween(1,4);
                    $commentaire->setEtablissement($etablissement);
                    $manager->persist($commentaire);
                }
                
                
                $commentaires []= $commentaire;
                
                $n++;
        }



        $manager->flush();

    }

    
}
