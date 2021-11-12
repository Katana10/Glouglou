<?php
/**
 * Class Profondeur
 * 
 *  Contient tous les champs de la Class Profondeur
 * 
 * @author TALIBART Killian
 * @version 7.4.10
 * 
 */
namespace App\Entity;

use App\Repository\ProfondeurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfondeurRepository::class)
 */
class Profondeur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $profondeur;

    /**
     * @ORM\ManyToOne(targetEntity=TablePlongee::class, inversedBy="correspond")
     */
    private $table_associee;

    /**
     * @ORM\OneToMany(targetEntity=Temps::class, mappedBy="est_a")
     */
    private $temps_associe;

    public function __construct()
    {
        $this->temps_associe = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfondeur(): ?int
    {
        return $this->profondeur;
    }

    public function setProfondeur(int $profondeur): self
    {
        $this->profondeur = $profondeur;

        return $this;
    }

    public function getTableAssociee(): ?TablePlongee
    {
        return $this->table_associee;
    }

    public function setTableAssociee(?TablePlongee $table_associee): self
    {
        $this->table_associee = $table_associee;

        return $this;
    }

    /**
     * @return Collection|Temps[]
     */
    public function getTempsAssocie(): Collection
    {
        return $this->temps_associe;
    }

    public function addTempsAssocie(Temps $tempsAssocie): self
    {
        if (!$this->temps_associe->contains($tempsAssocie)) {
            $this->temps_associe[] = $tempsAssocie;
            $tempsAssocie->setEstA($this);
        }

        return $this;
    }

    public function removeTempsAssocie(Temps $tempsAssocie): self
    {
        if ($this->temps_associe->contains($tempsAssocie)) {
            $this->temps_associe->removeElement($tempsAssocie);
            // set the owning side to null (unless already changed)
            if ($tempsAssocie->getEstA() === $this) {
                $tempsAssocie->setEstA(null);
            }
        }

        return $this;
    }

    public function __toString(): ?string
    {
        return $this->table_associee;
    }
}
