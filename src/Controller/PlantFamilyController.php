<?php

namespace App\Controller;


use App\Entity\User;
use App\Entity\Plant\PlantFamily;
use App\Entity\Plant\Plant;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PlantFamilyController extends AbstractController
{
    public function viewAll(): Response
    {
        $plantFamilyRepository = $this->getDoctrine()
            ->getRepository(PlantFamily::class);
            

        if (!$plantFamilyRepository) {
            throw $this->createNotFoundException(
                'Please add plant families to continue'
            );
        }
        $plantFamilies = $plantFamilyRepository->findAll();
        
        return $this->render('plant/plantFamilies.html.twig', [
            'families' => $plantFamilies,
        ]);
    }

    public function viewFamily(int $id): Response
    {
        $plantFamilyRepository = $this->getDoctrine()
            ->getRepository(PlantFamily::class);

        $plantRepository = $this->getDoctrine()
            ->getRepository(Plant::class);
            

        if (!$plantFamilyRepository) {
            throw $this->createNotFoundException(
                'Please add plant families to continue'
            );
        }

        if (!$plantRepository) {
            throw $this->createNotFoundException(
                'Please add a plant to this plant family to continue'
            );
        }

        $plants = $plantRepository->findBy(
            ['plantFamily' => $id]
        );

        
        $plantFamilies = $plantFamilyRepository->find($id);

        return $this->render('plant/plantFamily.html.twig', [
            'family' => $plantFamilies,
            'plants' => $plants
        ]);

    }
}
