<?php

namespace App\Controller;

use App\Entity\Garden\Specimen;
use App\Entity\Plant\FertilizerType;
use App\Entity\Plant\PlantFertilizerType;
use App\Form\PlantFertilizerTypeFormType;
use App\Service\SpecimenService;
use App\Repository\SpecimenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SpecimenController extends AbstractController
{


    public function setFertilizer(Request $request, SpecimenService $specimenService){
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        try {
            $specimenService->setFertilizer($request->get("id"),$request->get("fertilizerId"), new \DateTimeImmutable('now', new \DateTimeZone('UTC')));
            $response->setContent(json_encode([
                'Message' => 'Specimen has been fertilized with the chosen fertilizer',
                'Code' => 200
            ]));
        } catch (\Exception $e) {
            $response->setContent(json_encode([
                'Message' => $e->getMessage(),
                'Code' => 500
            ]));
        }
        return $response;
    }
    public function fertilize(Request $request, SpecimenService $specimenService)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        try {
            $specimenService->fertilize($request->get("id"), new \DateTimeImmutable('now', new \DateTimeZone('UTC')));
            $response->setContent(json_encode([
                'Message' => 'Specimen has been fertilized',
                'Code' => 200
            ]));
        } catch (\Exception $e) {
            $response->setContent(json_encode([
                'Message' => $e->getMessage(),
                'Code' => 500
            ]));
        }
        return $response;
    }

    public function waterize(Request $request, SpecimenService $specimenService): Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        try {
            $specimenService->waterize($request->get("id"), false, new \DateTimeImmutable('now', new \DateTimeZone('UTC')));
            $response->setContent(json_encode([
                'Message' => 'Specimen has been waterized',
                'Code' => 200
            ]));
        } catch (\Exception $e) {
            $response->setContent(json_encode([
                'Message' => $e->getMessage(),
                'Code' => 500
            ]));
        }
        return $response;
    }

    public function waterizePlot(Request $request, SpecimenService $specimenService): Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        try {
            $specimenService->waterizePlot($request->get("id"), false, new \DateTimeImmutable('now', new \DateTimeZone('UTC')));
            $response->setContent(json_encode([
                'Message' => 'Plot has been waterized',
                'Code' => 200
            ]));
        } catch (\Exception $e) {
            $response->setContent(json_encode([
                'Message' => $e->getMessage(),
                'Code' => 500
            ]));
        }
        return $response;
    }

    public function waterizeGarden(Request $request, SpecimenService $specimenService): Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        try {
            $specimenService->waterizeGarden($request->get("id"), false, new \DateTimeImmutable('now', new \DateTimeZone('UTC')));
            $response->setContent(json_encode([
                'Message' => 'Garden has been waterized',
                'Code' => 200
            ]));
        } catch (\Exception $e) {
            $response->setContent(json_encode([
                'Message' => $e->getMessage(),
                'Code' => 500
            ]));
        }
        return $response;
    }

    public function hourlyWeatherResult(Request $request, SpecimenService $specimenService): Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        try {
            if ($specimenService->hourlyWeatherResult(intval($request->query->get("id")))) {
                $specimenService->waterize($request->get("id"), true, new \DateTimeImmutable('now', new \DateTimeZone('UTC')));
                $response->setContent(json_encode([
                    'Message' => 'Specimen has been waterized by the rain',
                    'Code' => 200
                ]));
            } else {
                $response->setContent(json_encode([
                    'Message' => 'Specimen has not been waterized there is no rain',
                    'Code' => 200
                ]));
            }

        } catch (\Exception $e) {
            $response->setContent(json_encode([
                'Message' => $e->getMessage(),
                'Code' => 500
            ]));
        }
        return $response;
    }

    public function goToNextLifeCycleStep(Request $request, SpecimenService $specimenService): Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        try {
            $specimenService->goToNextLifeCycleStep($request->get("id"), new \DateTimeImmutable('now', new \DateTimeZone('UTC')));
            $response->setContent(json_encode([
                'Message' => 'Specimen next life cycle step',
                'Code' => 200
            ]));
        } catch (\Exception $e) {
            $response->setContent(json_encode([
                'Message' => $e->getMessage(),
                'Code' => 500
            ]));
        }
        return $response;

    }

    public function goToLifeCycleStep(Request $request, SpecimenService $specimenService): Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        try {
            $specimenService->goToLifeCycleStep($request->get("id"), $request->get("order"), new \DateTimeImmutable('now', new \DateTimeZone('UTC')));
            $response->setContent(json_encode([
                'Message' => 'Specimen life cycle step set',
                'Code' => 200
            ]));
        } catch (\Exception $e) {
            $response->setContent(json_encode([
                'Message' => $e->getMessage(),
                'Code' => 500
            ]));
        }
        return $response;
    }

    public function dailyLifeResult(Request $request, SpecimenService $specimenService): Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        try {
            $specimenService->dailyLifeResultForAllSpecimen(new \DateTimeImmutable('now', new \DateTimeZone('UTC')));
            $response->setContent(json_encode([
                'Message' => 'Specimen daily life result done',
                'Code' => 200
            ]));
        } catch (\Exception $e) {
            $response->setContent(json_encode([
                'Message' => $e->getMessage(),
                'Code' => 500
            ]));
        }
        return $response;

    }

    public function getSpecimenLifeResults(Request $request, SpecimenRepository $specimenRepository): Response
    {

        $dateBegin = new \DateTimeImmutable($request->request->get('dateBegin_tmtsp'));
        if(!(is_object($dateBegin))){
            $dateBegin = new \DateTimeImmutable('now');
        }

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $tempResponse = [];
        $specimen = $specimenRepository->find($request->get("id"));
        //$lifeResults = $specimen->getSpecimenLifeResults();
        $lifeResults = $specimenRepository->getSpecimenLifeResults($request->get("id"), $dateBegin->modify('-11 days'));
        dump($lifeResults);
        foreach ($lifeResults as $lifeResult) {
            $tempContent = [
                "waterEfficiency" => $lifeResult->getWaterEfficiency(),
                "soilEfficiency" => $lifeResult->getSoilEfficiency(),
                "sunExposureEfficiency" => $lifeResult->getSunExposureEfficiency(),
                "fertilizerEfficiency" => $lifeResult->getFertilizerEfficiency(),
                "totalEfficiency" => $lifeResult->getTotalEfficiency()];

            $tempResponse[] = [$lifeResult->getDate()->getTimestamp() => $tempContent];
        }
        $response->setContent(json_encode($tempResponse));
        return $response;
    }

    public function specimenFertilizerForm(Request $request, int $id = null): Response
    {
        $em = $this->getDoctrine()->getManager();

        if ($id > 0) {
            $specimen = $em->getRepository(Specimen::class)->find($id);
            if (!$specimen) throw $this->createNotFoundException('Specimen with id ' . $id . ' does not exist');
        } else $specimen = null;

        if($specimen->getFertilizer() !== null){
            $fertilizer = $specimen->getFertilizer();
        } else $fertilizer = $em->getRepository(FertilizerType::class)->findOneBy(['code' => 'N-K']);

        $form = $this->createForm(PlantFertilizerTypeFormType::class, new PlantFertilizerType($specimen->getPlant(), $fertilizer, 0, 0), [
            'action' => null
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($specimen);
            $em->flush();

            return new JsonResponse(1);
        }
        return $this->render('garden/specimen_fertilizer_form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
