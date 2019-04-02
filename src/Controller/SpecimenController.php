<?php

namespace App\Controller;

use App\Service\SpecimenService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SpecimenController extends AbstractController
{

    public function fertilize(Request $request, SpecimenService $specimenService): Response
    {
        $specimenService->fertilize($request->query->get("id"));
    }

    public function waterize(Request $request, SpecimenService $specimenService): Response
    {
        $specimenService->waterize($request->query->get("id"), false);
    }

    public function hourlyWeatherResult(Request $request, SpecimenService $specimenService): Response
    {
        if ($specimenService->hourlyWeatherResult($request->query->get("id"))) {
            $specimenService->waterize($request->query->get("id"), true);
        };
    }

    public function goToNextLifeCycleStep(Request $request, SpecimenService $specimenService): Response
    {
        $specimenService->goToNextLifeCycleStep($request->query->get("id"));
    }

    public function goToLifeCycleStep(Request $request, SpecimenService $specimenService): Response
    {
        $specimenService->goToLifeCycleStep($request->query->get("id"), $request->query->get("order"));
    }
}
