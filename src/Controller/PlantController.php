<?php

namespace App\Controller;


use App\Entity\Plant\FertilizerType;
use App\Entity\Plant\PlantFamily;
use App\Entity\Plant\PlantFertilizerType;
use App\Entity\Plant\Plant;
use App\Entity\Plant\PlantSoilType;
use App\Entity\Plant\PlantSunExposureType;
use App\Entity\Plant\SoilType;
use App\Entity\Plant\SunExposureType;
use App\Form\PlantFertilizerTypeFormType;
use App\Form\PlantType;
use App\Form\PlantSoilTypeFormType;
use App\Form\PlantSunExposureTypeFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    public function editPlant(Request $request, int $id = null): Response
    {
        $em = $this->getDoctrine()->getManager();

        if($id > 0) {
            $plant = $em->getRepository(Plant::class)->find($id);
            if (!$plant) throw $this->createNotFoundException('Plant with id '.$id.' does not exist');
        }
        else $plant = new Plant("", '', "",
                                new PlantFamily("", "", ""), 0);

        $formAction = $request->attributes->get('_route') == 'plant_create' ? $this->generateUrl('plant_create'): $this->generateUrl('plant_edit', ['id' => $plant->getId()]);

        $form = $this->createForm(PlantType::class, $plant, [
            'action' => $formAction]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($plant);
            $em->flush();

            if($request->attributes->get('_route') == 'plant_edit'){
                $word = 'modifié';
            } else $word = 'créé';

            $this->addFlash('success', 'Votre jardin "'.$plant->getName().'" a été '.$word.' avec succès ! Vous pouvez ajouter des plantes.');
            return $this->redirectToRoute('plants');
        }

        return $this->render('plant/form_plant.html.twig', [
            'formPlant' => $form->createView()
        ]);

    }

    public function addFertilizer(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $plant = $em->getRepository(Plant::class)->find($request->get('plantId'));

        $plantFertilizerType = new PlantFertilizerType(
            $plant,
            $em->getRepository(FertilizerType::class)->findOneBy(['code' => 'N-K']),
            0,
            0
        );

        $form = $this->createForm(PlantFertilizerTypeFormType::class, $plantFertilizerType,
            ['action' => $this->generateUrl('add_fertilizer', ['plantId' => $plant->getId()])]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('success', "soda");
            return $this->redirectToRoute('plants');
        }

        return $this->render('forms/plant/plant_attributes/form_plant_fertilizer.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function addSoil(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $plant = $em->getRepository(Plant::class)->find($request->get('plantId'));

        $plantSoilType = new PlantSoilType(
            $plant,
            $em->getRepository(SoilType::class)->findOneBy(['code' => 'clay']),
            0
        );

        $form = $this->createForm(PlantSoilTypeFormType::class, $plantSoilType,
            ['action' => $this->generateUrl('add_soil', ['plantId' => $plant->getId()])]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('success', "soda");
            return $this->redirectToRoute('plants');
        }

        return $this->render('forms/plant/plant_attributes/form_plant_soil.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function addSunExposure(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $plant = $em->getRepository(Plant::class)->find($request->get('plantId'));

        $sunExposureType = new PlantSunExposureType(
            $plant,
            $em->getRepository(SunExposureType::class)->findOneBy(['code' => 'sun']),
            0
        );

        $form = $this->createForm(PlantSunExposureTypeFormType::class, $sunExposureType,
            ['action' => $this->generateUrl('add_sun_exposure', ['plantId' => $plant->getId()])]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('success', "soda");
            return $this->redirectToRoute('plants');
        }

        return $this->render('forms/plant/plant_attributes/form_plant_sun_exposure.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
