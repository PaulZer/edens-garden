<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Garden\Garden;
use App\Entity\Garden\Plot;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class GardenController extends AbstractController
{
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
        $garden = new Garden('', 0, 0, 0, 0);
        $form = $this->createForm(GardenType::class, $garden, ['action' => $this->generateUrl('garden_create')]);
        $form->handleRequest($request);

        dump($form->isSubmitted());
        if ($form->isSubmitted() && $form->isValid()) {

            dump($garden);

            $this->addFlash('notice', "Your garden is created ! You can add your plants now !");
            return $this->redirectToRoute('index');
        }

        return $this->render('garden/modals.html.twig', [
            'modalTitle' => 'Créer un jardin',
            'template' => 'form_garden',
            'view' => $form->createView()
        ]);
    }
}
