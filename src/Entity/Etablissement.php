<?php

namespace App\Entity;

use App\Repository\EtablissementRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtablissementRepository::class)]
class Etablissement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    public $id;

    #[ORM\Column(type: 'string', length: 255)]
    public $appellation_officielle;

    #[ORM\Column(type: 'string', length: 255)]
    public $denomination_principale;

    #[ORM\Column(type: 'string', length: 255)]
    private $secteur;

    #[ORM\Column(type: 'float')]
    private $latitude;

    #[ORM\Column(type: 'float')]
    private $longitude;

    #[ORM\Column(type: 'string', length: 255)]
    private $adresse;

    #[ORM\Column(type: 'string', length: 255)]
    private $departement;

    #[ORM\Column(type: 'string', length: 255)]
    public $code_departement;

    #[ORM\Column(type: 'string', length: 255)]
    private $commune;

    #[ORM\Column(type: 'string', length: 255)]
    public $code_commune;

    #[ORM\Column(type: 'string', length: 255)]
    private $region;

    #[ORM\Column(type: 'string', length: 255)]
    public $code_region;

    #[ORM\Column(type: 'string', length: 255)]
    private $academie;

    #[ORM\Column(type: 'string', length: 255)]
    public $code_academie;

    #[ORM\Column(type: 'datetime', nullable: true)]
    public $date_ouverture;

    #[ORM\OneToMany(mappedBy: 'etablissement', targetEntity: Commentaires::class)]
    private $commentaires;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->date_ouverture = date_create('today');
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAppellationOfficielle(): ?string
    {
        return $this->appellation_officielle;
    }

    public function setAppellationOfficielle(string $appellation_officielle): self
    {
        $this->appellation_officielle = $appellation_officielle;

        return $this;
    }

    public function getDenominationPrincipale(): ?string
    {
        return $this->denomination_principale;
    }

    public function setDenominationPrincipale(string $denomination_principale): self
    {
        $this->denomination_principale = $denomination_principale;

        return $this;
    }

    public function getSecteur(): ?string
    {
        return $this->secteur;
    }

    public function setSecteur(string $secteur): self
    {
        $this->secteur = $secteur;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    public function setDepartement(string $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    public function getCodeDepartement(): ?string
    {
        return $this->code_departement;
    }

    public function setCodeDepartement(string $code_departement): self
    {
        $this->code_departement = $code_departement;

        return $this;
    }

    public function getCommune(): ?string
    {
        return $this->commune;
    }

    public function setCommune(string $commune): self
    {
        $this->commune = $commune;

        return $this;
    }

    public function getCodeCommune(): ?string
    {
        return $this->code_commune;
    }

    public function setCodeCommune(string $code_commune): self
    {
        $this->code_commune = $code_commune;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getCodeRegion(): ?string
    {
        return $this->code_region;
    }

    public function setCodeRegion(string $code_region): self
    {
        $this->code_region = $code_region;

        return $this;
    }

    public function getAcademie(): ?string
    {
        return $this->academie;
    }

    public function setAcademie(string $academie): self
    {
        $this->academie = $academie;

        return $this;
    }

    public function getCodeAcademie(): ?string
    {
        return $this->code_academie;
    }

    public function setCodeAcademie(string $code_academie): self
    {
        $this->code_academie = $code_academie;

        return $this;
    }

    public function getDateOuverture()
    {
        return $this->date_ouverture->format('d/m/Y');
    }

    public function setDateOuverture($date_ouverture): self
    {
        $this->date_ouverture  = $date_ouverture; //new \DateTime('11/12/1996');
      //  $this->date_ouverture =new \DateTime(\DateTime::createFromFormat('d/m/Y', $date_ouverture)->format('d/m/Y'));
       /* $date = new \DateTime($date_ouverture);
        $this->date_ouverture = $date;*/

        return $this;
    }

    /**
     * @return Collection<int, Commentaires>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaires $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setEtablissement($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaires $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getEtablissement() === $this) {
                $commentaire->setEtablissement(null);
            }
        }

        return $this;
    }
}
