<?php

namespace App\DataFixtures;

use App\Entity\Etablissement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    /**
     * @Assert\DateTime
     * @var string A "d/m/Y" formatted value
    */
    public $date;

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
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
       // dd($donnees);

        foreach($donnees as $donnee) {
                //print_r($donnee[0]);
                $d = $donnee[0];
                //print_r($d . PHP_EOL . PHP_EOL);
                $data = explode(";", $d);
                print_r($data);
                $etablissement = new Etablissement();
                $etablissement->setAppellationOfficielle($data[1]);
                $etablissement->setDenominationPrincipale($data[2]);
                $etablissement->setSecteur($data[4]);
                $etablissement->setLatitude(floatval($data[14]));
                $etablissement->setLongitude(floatval($data[15]));
                $etablissement->setAdresse($data[5]);
                $etablissement->setDepartement($data[26]);
                $etablissement->setCommune($data[10]);
                $etablissement->setRegion($data[27]);
                $etablissement->setAcademie($data[28]);
                
                
                //$d = \DateTime::createFromFormat('d/m/Y', $data[34])->format('d/m/Y');
                //if($data != '') {
                    //$date = \DateTime::createFromFormat('d/m/Y', $data[34]);
                    //$date = $date->format('d/m/Y');
                    //$date = new \DateTime($data[34]); 
                    //$etablissement->date_ouverture = new \DateTime($data[34]);
                    //$etablissement->date_ouverture;
                    
                    //$etablissement->date_ouverture = new \DateTime();
                //}
                

                print("Appelation : " .$etablissement->getAppellationOfficielle(). PHP_EOL);
                print("Denomination : " .$etablissement->getDenominationPrincipale(). PHP_EOL);
                print("Secteur : " .$etablissement->getSecteur(). PHP_EOL);
                print("Latitude : " .$etablissement->getLatitude(). PHP_EOL);
                print("Longitude : " .$etablissement->getLongitude(). PHP_EOL);
                print("Addresse : " .$etablissement->getAdresse(). PHP_EOL);
                print("Departement : " .$etablissement->getDepartement(). PHP_EOL);
                print("Commune : " .$etablissement->getCommune(). PHP_EOL);
                print("Region : " .$etablissement->getRegion(). PHP_EOL);
                print("Academie : " .$etablissement->getAcademie(). PHP_EOL);
               // print("Date : " .$etablissement->getDateOuverture(). PHP_EOL);

                print( PHP_EOL .  PHP_EOL);
                $manager->persist($etablissement);

        }
        print($i);
       /* $i = 0;
        foreach ($donnees as $donnee) {
            foreach ($donnee as $d) {
                $i++;
                $data = explode(";", $d);
                dd($i);
                if ($i > 1) {
                    dd($data[1]);
                    $date=''!==$data[33]?new \DateTime($data[33]):null;
                    $etablissement = new Etablissement();
                    $etablissement->setAppellationOfficielle($data[1]);
                    $etablissement->setDenominationPrincipale($data[19]);
                    $etablissement->setAcademie($data[24]);
                    $etablissement->setRegion($data[27]);
                    $etablissement->setAdresse($data[5]);
                    $etablissement->setCommune((string)$data[10]);
                    $etablissement->setDateOuverture($date);
                    $etablissement->setDepartement($data[26]);
                    $etablissement->setLatitude($data[14]);
                    $etablissement->setLongitude($data[15]);
                    $etablissement->setSecteurEtablissement($data[4]);

                    $manager->persist($etablissement);
                }
            }

        }*/

       $manager->flush();
    }
}
