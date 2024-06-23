<?php

namespace App\Controller;

use App\Entity\Citation;
use App\Repository\AuteurRepository;
use App\Repository\CitationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AfficheCitationController extends AbstractController
{
    /**
     * @Route("/affiche-citation", name="affiche_citation")
     */
    public function index(Request $request, CitationRepository $citationRepository, AuteurRepository $auteurRepository): Response
    {
        // Récupérez les paramètres de la requête
        $searchKeyword = $request->query->get('search', '');
        $selectedAuthor = $request->query->get('author', '');
        $selectedCentury = $request->query->get('siecle', '');
        $sortOrder = $request->query->get('sort', 'author');

        // Initialisez le gestionnaire d'entités
        $entityManager = $this->getDoctrine()->getManager();

        // Commencez à construire votre requête
        $queryBuilder = $entityManager->createQueryBuilder()
            ->select('citation')
            ->from(Citation::class, 'citation');

        $queryBuilder->leftJoin('citation.auteur', 'auteur');

        // Ajoutez des conditions en fonction des paramètres de recherche
        if ($searchKeyword) {
            $queryBuilder
                ->andWhere('LOWER(citation.text) LIKE LOWER(:searchKeyword)')
                ->setParameter('searchKeyword', '%' . $searchKeyword . '%');
        }

        if ($selectedAuthor) {
            // Recherche de l'auteur par nom et prénom
            $author = $auteurRepository->findOneByNomPrenom($selectedAuthor);
            if ($author) {
                $queryBuilder
                    ->andWhere('auteur.idauteur = :selectedAuthor')
                    ->setParameter('selectedAuthor', $author->getIdauteur());
            }
        }

        if ($selectedCentury) {
            $queryBuilder
                ->andWhere('auteur.siecle = :selectedCentury')
                ->setParameter('selectedCentury', $selectedCentury);
        }

        // Triez les résultats en fonction du choix de l'utilisateur
        if ($sortOrder === 'author') {
            $queryBuilder->orderBy('auteur.nom', 'ASC');
        } elseif ($sortOrder === 'siecle') {
            $queryBuilder->orderBy('auteur.siecle', 'ASC');
        }

        // Exécutez la requête et récupérez les résultats
        $query = $queryBuilder->getQuery();
        $citations = $query->getResult();


        // Renvoyez les résultats à la vue Twig
        return $this->render('affiche_citation/index.html.twig', [
            'citations' => $citations,
            'searchKeyword' => $searchKeyword,
            'selectedAuthor' => $selectedAuthor,
            'selectedCentury' => $selectedCentury,
            'sortOrder' => $sortOrder,
        ]);
    }
}
