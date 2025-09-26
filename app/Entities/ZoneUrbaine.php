<?php
namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: "zones_urbaines")]
class ZoneUrbaine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 100)]
    private string $nom;

    #[ORM\Column(type: "integer")]
    private int $population = 0;

    #[ORM\Column(type: "float")]
    private float $surface = 0;

    #[ORM\Column(type: "float")]
    private float $niveauPollution = 0;

    #[ORM\Column(type: "integer")]
    private int $nbArbresExist = 0;


    #[ORM\OneToMany(
    targetEntity: Batiment::class,
    mappedBy: "zone",
    cascade: ["persist", "remove"],
    fetch: "EAGER"   // ← ça force le chargement direct
)]
private Collection $batiments;


    public function __construct()
    {
        $this->batiments = new ArrayCollection();
    }

    // ---- Getters & Setters ----
    public function getId(): int { return $this->id; }

    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): void { $this->nom = $nom; }

    public function getPopulation(): int { return $this->population; }
    public function setPopulation(int $pop): void { $this->population = $pop; }

    public function getSurface(): float { return $this->surface; }
    public function setSurface(float $surf): void { $this->surface = $surf; }

    public function getNiveauPollution(): float { return $this->niveauPollution; }
    public function setNiveauPollution(float $niv): void { $this->niveauPollution = $niv; }

    public function getNbArbresExist(): int { return $this->nbArbresExist; }
    public function setNbArbresExist(int $nb): void { $this->nbArbresExist = $nb; }

    /**
     * Retourne la collection de Bâtiments liés
     */
    public function getBatiments(): Collection { return $this->batiments; }

    public function addBatiment(Batiment $b): void
    {
        if (!$this->batiments->contains($b)) {
            $this->batiments->add($b);
            $b->setZone($this);
        }
    }

   public function removeBatiment(Batiment $b): void
{
    if ($this->batiments->removeElement($b)) {
        if ($b->getZone() === $this) {
            $b->setZone(null); // maintenant accepté
        }
    }
}


    /**
     * Calcul automatique du besoin en arbres (nbArbresBesoin)
     * Supposons : 1 arbre absorbe 0.02 t CO₂ / an
     */
    public function getNbArbresBesoin(): int
    {
        $totalEmission = 0;
        foreach ($this->batiments as $b) {
            $totalEmission += $b->getEmissionReelle();
        }
        return (int) ceil($totalEmission / 0.02);
    }
    public function __toString(): string
{
    return $this->nom;
}

}
