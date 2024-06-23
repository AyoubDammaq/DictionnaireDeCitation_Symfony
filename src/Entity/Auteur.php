<?php

namespace App\Entity;

use App\Repository\AuteurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AuteurRepository::class)
 */
class Auteur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $idauteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $siecle;

    // ... Ajoutez les méthodes getters et setters appropriées

    public function getIdauteur(): ?int
    {
        return $this->idauteur;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of siecle.
     *
     * @return int|null
     */
    public function getSiecle(): ?int
    {
        return $this->siecle;
    }

    /**
     * Set the value of siecle.
     *
     * @param int|null $siecle
     *
     * @return self
     */
    public function setSiecle(?int $siecle): self
    {
        $this->siecle = $siecle;

        return $this;
    }
}
