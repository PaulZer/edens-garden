<?php

namespace App\Controller;

use App\Repository\SpecimenRepository;
use App\Service\SpecimenService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Garden\Specimen;

class SpecimenController extends AbstractController
{

    public function fertilize(Request $request, SpecimenService $specimenService): Response
    {
        $specimenService->fertilize($request->query->get("id"));
    }

    public function waterize(Request $request, SpecimenService $specimenService): Response
    {
        $specimenService->waterize($request->query->get("id"));
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
