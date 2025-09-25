<?php
namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "batiments")]
class Batiment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 50)]
    private string $type_batiment; // "Usine" ou "Maison"

   #[ORM\Column(type: "string", length: 255)]
    private string $adresse;

    #[ORM\Column(type: "float")]
    private float $emissionCO2;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $nbHabitants = null;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $nbEmployes = null;

    #[ORM\Column(type: "string", length: 50, nullable: true)]
    private ?string $typeIndustrie = null;

    #[ORM\Column(type: "float")]
    private float $pourcentageRenouvelable = 0.0;

    #[ORM\Column(type: "float")]
    private float $emissionReelle = 0.0;

    #[ORM\ManyToOne(targetEntity: ZoneUrbaine::class, inversedBy: "batiments")]
    #[ORM\JoinColumn(name: "zone_id", referencedColumnName: "id", onDelete: "CASCADE")]
    private ?ZoneUrbaine $zone = null;

    // ---- Getters & Setters ----
    public function getId(): int { return $this->id; }

    public function getTypeBatiment(): string { return $this->type_batiment; }
    public function setTypeBatiment(string $type): void { $this->type_batiment = $type; }

    public function getAdresse(): string { return $this->adresse; }
    public function setAdresse(string $adresse): void { $this->adresse = $adresse; }

    public function getEmissionCO2(): float { return $this->emissionCO2; }
    public function setEmissionCO2(float $co2): void {
        $this->emissionCO2 = $co2;
        $this->updateEmissionReelle();
    }

    public function getNbHabitants(): ?int { return $this->nbHabitants; }
    public function setNbHabitants(?int $nb): void { $this->nbHabitants = $nb; }

    public function getNbEmployes(): ?int { return $this->nbEmployes; }
    public function setNbEmployes(?int $nb): void { $this->nbEmployes = $nb; }


    public function getTypeIndustrie(): ?string { return $this->typeIndustrie; }
    public function setTypeIndustrie(?string $type): void { $this->typeIndustrie = $type; }

    public function getPourcentageRenouvelable(): float { return $this->pourcentageRenouvelable; }
    public function setPourcentageRenouvelable(float $pct): void {
        $this->pourcentageRenouvelable = $pct;
        $this->updateEmissionReelle();
    }

    public function getEmissionReelle(): float { return $this->emissionReelle; }

    private function updateEmissionReelle(): void {
        $this->emissionReelle = $this->emissionCO2 * (1 - $this->pourcentageRenouvelable / 100);
    }

    public function getZone(): ?ZoneUrbaine
{
    return $this->zone;
}

public function setZone(?ZoneUrbaine $zone): void
{
    $this->zone = $zone;
}
/**
 * Calcul du nombre d'arbres nécessaires pour compenser ce bâtiment
 * Hypothèse : 1 arbre absorbe 0.02 tCO₂/an
 */
public function getNbArbresBesoin(): int
{
    return (int) ceil($this->emissionReelle / 0.02);
}
}
