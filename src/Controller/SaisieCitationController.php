<?php

namespace App\Controller;

use App\Entity\Citation;
use App\Entity\Auteur; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SaisieCitationController extends AbstractController
{
    /**
     * @Route("/saisie-citation", name="saisie_citation")
     */
    public function index(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $message = null;

        if ($request->isMethod('POST')) {
            $nom = $request->request->get('nom');
            $prenom = $request->request->get('prenom');
            $siecle = $request->request->get('siecle');
            $texte = $request->request->get('texte');

            $siecle = ($siecle !== null) ? (int)$siecle : null;

            // Vérifiez si l'auteur existe déjà dans la base
            $auteur = $entityManager->getRepository(Auteur::class)->findOneBy(['nom' => $nom, 'prenom' => $prenom, 'siecle' => $siecle]);

            if (!$auteur) {
                // Si l'auteur n'existe pas, créez un nouvel auteur
                $auteur = new Auteur();
                $auteur->setNom($nom);
                $auteur->setPrenom($prenom);
                $auteur->setSiecle($siecle);

                $entityManager->persist($auteur);
                $entityManager->flush();
            }

            // Créez la citation et associez-la à l'auteur
            $citation = new Citation();
            $citation->setText($texte);
            $citation->setAuteur($auteur);

            $entityManager->persist($citation);
            $entityManager->flush();

            $message = 'Citation ajoutée avec succès!';
        }

        return $this->render('saisie_citation/index.html.twig', [
            'message' => $message,
        ]);
    }
}