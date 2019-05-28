<?php

namespace App\Controller;

use App\Entity\API\CurrentWeather;
use App\Entity\API\WeatherForecast;
use App\Entity\Garden\Garden;
use App\Entity\Garden\Plot;
use App\Form\GardenType;
use Doctrine\Common\Persistence\ObjectManager;
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
        if (!$garden) throw $this->createNotFoundException('Garden with id ' . $id . ' does not exist');
        $currentWeatherObject = new CurrentWeather($garden->getLatitude(), $garden->getLongitude(), '41483201f4e8d0ac0d8fd986ac4adb01');
        $weatherForecastObject = new WeatherForecast($garden->getLatitude(), $garden->getLongitude(), '41483201f4e8d0ac0d8fd986ac4adb01');
        $currentWeatherData = $currentWeatherObject->getCurrentWeatherData();
        $weatherForecastData = $weatherForecastObject ->getWeatherForecastData();
        $currentWeather = $currentWeatherObject->formatCurrentWeatherArray($currentWeatherData);
        $weatherForecast = $weatherForecastObject->formatWeatherForecastArray($weatherForecastData);

        return $this->render('garden/garden.html.twig', ['garden' => $garden,
                                                    'currentWeather'=> $currentWeather,
                                                    'weatherForecast' => $weatherForecast
        ]);
    }

    public function editGarden(Request $request, int $id = null): Response
    {
        $em = $this->getDoctrine()->getManager();

        if ($id > 0) {
            $garden = $em->getRepository(Garden::class)->find($id);
            if (!$garden) throw $this->createNotFoundException('Garden with id ' . $id . ' does not exist');
        } else $garden = new Garden($this->getUser(), '', 0, 0, 0, 0);

        $formAction = $request->attributes->get('_route') == 'garden_create' ? $this->generateUrl('garden_create') : $this->generateUrl('garden_edit', ['id' => $garden->getId()]);

        $form = $this->createForm(GardenType::class, $garden, [
            'action' => $formAction]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($garden);
            $em->flush();

            if ($request->attributes->get('_route') == 'garden_edit') {
                $word = 'modifié';
            } else $word = 'créé';

            $this->addFlash('success', 'Votre jardin "' . $garden->getName() . '" a été ' . $word . ' avec succès ! Vous pouvez ajouter des plantes.');
            return $this->redirectToRoute('index');
        }

        return $this->render('modals.html.twig', [
            'modalTitle' => $request->attributes->get('_route') == 'garden_create' ? 'Créer un jardin' : $garden->getName() . ' - Édition',
            'template' => 'garden/form_garden',
            'view' => $form->createView()
        ]);
    }

    public function addPlant(Request $request, ObjectManager $om): Response
    {
        if($request->getMethod() === "GET"){
            $gardenId = intval($request->query->get('gardenId'));
            $plotId = intval($request->query->get('plotId'));

            if($gardenId > 0) $garden = $om->getRepository(Garden::class)->find($gardenId);
            else $garden = null;
            if($plotId > 0) $plot = $om->getRepository(Plot::class)->find($plotId);
            else $plot = null;

            return $this->render('modals.html.twig', [
                'modalTitle' => 'Planter dans le jardin',
                'template' => 'garden/form_garden',
                'garden' => $garden,
                'plot' => $plot
            ]);
        } elseif($request->getMethod() === "POST"){
            //TODO
        }
    }
}
