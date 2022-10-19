<?php

namespace App\Controller;

use App\Entity\Weather;
use App\Form\WeatherType;
use App\Repository\CityRepository;
use App\Repository\WeatherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/weathers')]
class WeathersController extends AbstractController
{
    #[Route('/', name: 'app_weathers_index', methods: ['GET'])]
    public function index(WeatherRepository $weatherRepository): Response
    {
        return $this->render('weathers/index.html.twig', [
            'weather' => $weatherRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_weathers_new', methods: ['GET', 'POST'])]
    public function new(Request $request, WeatherRepository $weatherRepository): Response
    {
        $weather = new Weather();
        $form = $this->createForm(WeatherType::class, $weather, ['validation_groups' => ['edit']
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $weatherRepository->save($weather, true);

            return $this->redirectToRoute('app_weathers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('weathers/new.html.twig', [
            'weather' => $weather,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_weathers_show', methods: ['GET'])]
    public function show(Weather $weather): Response
    {
        return $this->render('weathers/show.html.twig', [
            'weather' => $weather,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_weathers_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Weather $weather, WeatherRepository $weatherRepository): Response
    {
        $form = $this->createForm(WeatherType::class, $weather, ['validation_groups' => ['edit']
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $weatherRepository->save($weather, true);

            return $this->redirectToRoute('app_weathers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('weathers/edit.html.twig', [
            'weather' => $weather,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_weathers_delete', methods: ['POST'])]
    public function delete(Request $request, Weather $weather, WeatherRepository $weatherRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$weather->getId(), $request->request->get('_token'))) {
            $weatherRepository->remove($weather, true);
        }

        return $this->redirectToRoute('app_weathers_index', [], Response::HTTP_SEE_OTHER);
    }

}
