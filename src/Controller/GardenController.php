<?php

namespace App\Controller;
use App\Entity\Garden\Garden;
use App\Form\GardenType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GardenController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    public function viewAll(): Response
    {
        $gardenRepository = $this->getDoctrine()
            ->getRepository(Garden::class);
            

        if (!$gardenRepository) {
            throw $this->createNotFoundException(
                'Please add a garden to continue'
            );
        }
        $gardens = $gardenRepository->findAll();
        
        return $this->render('garden/gardens.html.twig', [
            'gardens' => $gardens
        ]);
    }

    public function viewGarden(int $id): Response
    {
        $garden = $this->getDoctrine()
            ->getRepository(Garden::class)
            ->findOneBy(
                ['id' => $id]
            );

        if (!$garden) {
            throw $this->createNotFoundException(
                'Please add a garden to continue'
            );
        }
       
        return $this->render('garden/garden.html.twig', ['garden' => $garden]);
    }
  
    public function createGarden(Request $request):Response
    {
        $garden = new Garden($this->getUser(), '', 0, 0, 0, 0);
        $form = $this->createForm(GardenType::class, $garden, ['action' => $this->generateUrl('garden_create')]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($garden);
            $em->flush();

            $this->addFlash('success', "Votre jardin a été créé avec succès ! Vous pouvez ajouter des plantes.");
            return $this->redirectToRoute('index');
        }

        return $this->render('garden/modals.html.twig', [
            'modalTitle' => 'Créer un jardin',
            'template' => 'form_garden',
            'view' => $form->createView()
        ]);
    }
}
