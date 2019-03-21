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
        //TODO add weather
        $specimenService->waterize($request->query->get("id"), 0);
    }

    public function goToNextLifeCycleStep(Request $request, SpecimenService $specimenService): Response
    {
        $specimenService->goToNextLifeCycleStep($request->query->get("id"));
    }

    public function goToLifeCycleStep(Request $request, SpecimenService $specimenService): Response
    {
        $specimenService->goToLifeCycleStep($request->query->get("id"),$request->query->get("order"));
    }
}
