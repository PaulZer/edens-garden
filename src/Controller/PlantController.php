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

class PlantController extends AbstractController
{
    public function viewAll(): Response
    {
        $plantRepository = $this->getDoctrine()
            ->getRepository(Plant::class);
            

        if (!$plantRepository) {
            throw $this->createNotFoundException(
                'Please add a plant to continue'
            );
        }
        $plants = $plantRepository->findAll();
        
        return $this->render('plant/plants.html.twig', [
            'plants' => $plants
        ]);
    }

    public function viewPlant(int $id): Response
    {
        $plant = $this->getDoctrine()
            ->getRepository(Plant::class)
            ->findOneBy(
                ['id' => $id]
            );

        if (!$plant) {
            throw $this->createNotFoundException(
                'Please add a plant to this plant family to continue'
            );
        }
       
        return $this->render('plant/plant.html.twig', ['plant' => $plant]);

    }
}
