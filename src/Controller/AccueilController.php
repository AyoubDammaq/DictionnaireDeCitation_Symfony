<?php

namespace App\Controller;

use App\Repository\CitationRepository;
use App\Repository\AuteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(CitationRepository $citationRepository, AuteurRepository $auteurRepository): Response
    {
        // Fetch a random citation for the banner
        $citationDuJour = $citationRepository->findRandomCitation();

        // Fetch distinct authors for the dropdown
        $authors = $auteurRepository->findDistinctAuthors();

        return $this->render('acceuil/index.html.twig', [
            'citationDuJour' => $citationDuJour,
            'authors' => $authors,
        ]);
    }
}
