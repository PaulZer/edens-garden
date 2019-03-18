<?php

namespace App\Controller;

use App\Entity\Garden\Garden;
use App\Form\GardenType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GardenController extends AbstractController
{

    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    public function createGarden(Request $request):Response
    {
        $garden = new Garden('', 0, 0, 0, 0);
        $form = $this->createForm(GardenType::class, $garden);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('notice', "Your garden is created ! You can add your plants now !");
            return $this->redirectToRoute('index');
        }

        return $this->render('garden/modals.html.twig', [
            'modalTitle' => 'Créer un jardin',
            'template' => 'form_add_garden',
            'view' => $form->createView(),

        ]);
    }
}
