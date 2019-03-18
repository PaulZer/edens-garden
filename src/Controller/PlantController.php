<?php

namespace App\Controller;


use App\Entity\User;
use App\Entity\Plant\PlantFamily;
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
    

    public function view(): Response
    {
        $plantFamilyRepository = $this->getDoctrine()
            ->getRepository(PlantFamily::class);
            

        if (!$plantFamilyRepository) {
            throw $this->createNotFoundException(
                'Please add plant families to continue'
            );
        }
        $plantFamilies = $plantFamilyRepository->findAll();
        
        return $this->render('plant/plant.html.twig', [
            'families' => $plantFamilies,
        ]);
    }
}
