<?php
/**
 * Class TablePlongee
 * 
 *  Contient tous les champs de la Class TablePlongee 
 * 
 * @author TALIBART Killian
 * @version 7.4.10
 * 
 */
namespace App\Entity;

use App\Repository\TablePlongeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TablePlongeeRepository::class)
 */
class TablePlongee
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Profondeur::class, mappedBy="table_associee")
     */
    private $correspond;

    public function __construct()
    {
        $this->correspond = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|Profondeur[]
     */
    public function getCorrespond(): Collection
    {
        return $this->correspond;
    }

    public function addCorrespond(Profondeur $correspond): self
    {
        if (!$this->correspond->contains($correspond)) {
            $this->correspond[] = $correspond;
            $correspond->setTableAssociee($this);
        }

        return $this;
    }

    public function removeCorrespond(Profondeur $correspond): self
    {
        if ($this->correspond->contains($correspond)) {
            $this->correspond->removeElement($correspond);
            // set the owning side to null (unless already changed)
            if ($correspond->getTableAssociee() === $this) {
                $correspond->setTableAssociee(null);
            }
        }

        return $this;
    }

    public function __toString(): ?string
    {
        return $this->id;
    }
}
