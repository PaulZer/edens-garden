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
  
    /*public function createGarden(Request $request):Response
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
    }*/

    public function editGarden(Request $request, int $id = null):Response
    {
        $em = $this->getDoctrine()->getManager();

        if($id > 0) $garden = $em->getRepository(Garden::class)->find($id);
        else $garden = new Garden($this->getUser(), '', 0, 0, 0, 0);

        $formAction = $request->attributes->get('_route') == 'garden_create' ? $this->generateUrl('garden_create'): $this->generateUrl('garden_edit', ['id' => $garden->getId()]);

        $form = $this->createForm(GardenType::class, $garden, [
            'action' => $formAction]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($garden);
            $em->flush();

            if($request->attributes->get('_route') == 'garden_edit'){
                $word = 'modifié';
            } else $word = 'créé';

            $this->addFlash('success', "Votre jardin a été ".$word." avec succès ! Vous pouvez ajouter des plantes.");
            return $this->redirectToRoute('index');
        }

        return $this->render('modals.html.twig', [
            'modalTitle' => $request->attributes->get('_route') == 'garden_create' ? 'Créer un jardin': $garden->getName().' - Édition',
            'template' => 'garden/form_garden',
            'view' => $form->createView()
        ]);
    }
}
