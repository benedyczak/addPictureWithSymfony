<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\PhotoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddPhotoController extends AbstractController
{
    /**
     * @Route("/", name="app_addphoto")
     */
    public function ajouterImage(Request $request, EntityManagerInterface $entityManager): Response
    {
        $image = new Photo();
        $form = $this->createForm(PhotoType::class, $image);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer l'image dans la base de données
            $entityManager->persist($image);
            $entityManager->flush();

            // Rediriger l'utilisateur vers une page de confirmation ou d'affichage de l'image
            return $this->render('resultat.html.twig', [
                'id' => $image->getId(),
            ]);
        }

        // Afficher le formulaire
        return $this->render('add_photo/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
?>