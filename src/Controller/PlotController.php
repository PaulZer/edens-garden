<?php

namespace App\Controller;


use App\Entity\User;
use App\Entity\Garden\Garden;
use App\Entity\Garden\Plot;
use App\Form\GardenType;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PlotController extends AbstractController
{
    public function viewAll(): Response
    {
        $plotRepository = $this->getDoctrine()
            ->getRepository(Plot::class);
            

        if (!$plotRepository) {
            throw $this->createNotFoundException(
                'Please add a plot to continue'
            );
        }
        $plots = $plotRepository->findAll();
        
        return $this->render('garden/plots.html.twig', [
            'plots' => $plots
        ]);
    }

    public function viewPlot(int $id): Response
    {
        $plot = $this->getDoctrine()
            ->getRepository(Plot::class)
            ->findOneBy(
                ['id' => $id]
            );

        if (!$plot) {
            throw $this->createNotFoundException(
                'Please add a plot to continue'
            );
        }
       
        return $this->render('garden/plot.html.twig', ['plot' => $plot]);
    }

    public function editPlot(Request $request, int $id = null): Response
    {
        $em = $this->getDoctrine()->getManager();

        if ($id > 0) {
            $plot = $em->getRepository(Plot::class)->find($id);
            if (!$plot) throw $this->createNotFoundException('Plot with id ' . $id . ' does not exist');
        } else $plot = null;


        return $this->render('modals.html.twig', [
            'modalTitle' => 'Parcelle '.$plot->getName(),
            'plot' => $plot
        ]);
    }
}