<?php

namespace App\Entity;

use App\Repository\CitationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CitationRepository::class)
 */
class Citation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $idcit;

    /**
     * @ORM\Column(type="text")
     */
    private $text; // This property represents the text attribute

    /**
     * @ORM\ManyToOne(targetEntity="Auteur")
     * @ORM\JoinColumn(name="idauteur", referencedColumnName="idauteur", nullable=false)
     */
    private $auteur;

    // ... Ajoutez les méthodes getters et setters appropriées

    public function getIdcit(): ?int
    {
        return $this->idcit;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getAuteur(): ?Auteur
    {
        return $this->auteur;
    }

    public function setAuteur(?Auteur $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }
}