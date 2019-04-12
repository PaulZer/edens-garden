<?php

namespace App\Controller;


use App\Entity\Garden\Plot;
use App\Form\PlotType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    public function modalPlot(int $id = null): Response
    {
        $em = $this->getDoctrine()->getManager();

        if ($id > 0) {
            $plot = $em->getRepository(Plot::class)->find($id);
            if (!$plot) throw $this->createNotFoundException('Plot with id ' . $id . ' does not exist');
        } else $plot = null;


        return $this->render('modals.html.twig', [
            'modalTitle' => 'Parcelle '.$plot->getName(),
            'plot' => $plot,
        ]);
    }

    public function addPlot(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $plot = new Plot("", null, null);

        $formAction = "plot_create";

        $form = $this->createForm(PlotType::class, $plot, [
            'action' => $formAction]);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($plot);
            $em->flush();

            $this->addFlash('success', 'Votre parcelle "' . $plot->getName() . '" a été créé avec succès !');
            return $this->redirectToRoute('plots');
        }

        return $this->render('garden/form_plot.html.twig', [
            'formPlot' => $form->createView()
        ]);
    }

    public function editPlot(Request $request): Response
    {
        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();

        if ($id > 0) {
            $plot = $em->getRepository(Plot::class)->find($id);
            if (!$plot) throw $this->createNotFoundException('Plot with id ' . $id . ' does not exist');
        } else $plot = null;

        $formAction = $request->attributes->get('_route') == 'plot_create' ? $this->generateUrl('plot_create'): $this->generateUrl('plot_edit', ['id' => $plot->getId()]);

        $form = $this->createForm(PlotType::class, $plot, [
            'action' => $formAction]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($plot);
            $em->flush();

            $this->addFlash('success', 'Votre parcelle "' . $plot->getName() . '" a été modifié avec succès !');
            return $this->redirectToRoute('garden', ['id' => $plot->getGardenId()]);
        }

        return $this->render('garden/form_plot.html.twig', [
            'formPlot' => $form->createView()
        ]);
    }

    public function deletePlot(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');

        if(isset($id) && $id > 0)
        {
            $plot = $em->getRepository(Plot::class)->find($id);
            if (!$plot) throw $this->createNotFoundException('Plot with id '.$id.' does not exist');
            $em->remove($plot);
            $em->flush();

            return $this->redirectToRoute('garden', ['id' => $plot->getGardenId()]);
        }
        else throw $this->createNotFoundException('Plot with id '.$id.' does not exist');

    }
}