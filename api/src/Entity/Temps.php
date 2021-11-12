<?php
/**
 * Class Temps
 * 
 *  Contient tous les champs de la Class Temps
 * 
 * @author TALIBART Killian
 * @version 7.4.10
 * 
 */
namespace App\Entity;

use App\Repository\TempsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TempsRepository::class)
 */
class Temps
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
    private $temps;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $palier15;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $palier12;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $palier9;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $palier6;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $palier3;

    /**
     * @ORM\ManyToOne(targetEntity=Profondeur::class, inversedBy="temps_associe")
     */
    private $est_a;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemps(): ?int
    {
        return $this->temps;
    }

    public function setTemps(int $temps): self
    {
        $this->temps = $temps;

        return $this;
    }

    public function getPalier15(): ?int
    {
        return $this->palier15;
    }

    public function setPalier15(int $palier15): self
    {
        $this->palier15 = $palier15;

        return $this;
    }

    public function getPalier12(): ?int
    {
        return $this->palier12;
    }

    public function setPalier12(int $palier12): self
    {
        $this->palier12 = $palier12;

        return $this;
    }

    public function getPalier9(): ?int
    {
        return $this->palier9;
    }

    public function setPalier9(int $palier9): self
    {
        $this->palier9 = $palier9;

        return $this;
    }

    public function getPalier6(): ?int
    {
        return $this->palier6;
    }

    public function setPalier6(int $palier6): self
    {
        $this->palier6 = $palier6;

        return $this;
    }

    public function getPalier3(): ?int
    {
        return $this->palier3;
    }

    public function setPalier3(int $palier3): self
    {
        $this->palier3 = $palier3;

        return $this;
    }

    public function getEstA(): ?Profondeur
    {
        return $this->est_a;
    }

    public function setEstA(?Profondeur $est_a): self
    {
        $this->est_a = $est_a;

        return $this;
    }

        
}
