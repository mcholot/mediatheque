<?php

namespace App\Controller;

use App\Entity\Artistes;
use App\Form\ArtistesType;
use App\Repository\ArtistesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/artistes")
 */
class ArtistesController extends AbstractController
{
    /**
     * @Route("/", name="artistes_index", methods={"GET"})
     */
    public function index(ArtistesRepository $artistesRepository): Response
    {
        return $this->render('artistes/index.html.twig', [
            'artistes' => $artistesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="artistes_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $artiste = new Artistes();
        $form = $this->createForm(ArtistesType::class, $artiste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($artiste);
            $entityManager->flush();

            return $this->redirectToRoute('artistes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('artistes/new.html.twig', [
            'artiste' => $artiste,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="artistes_show", methods={"GET"})
     */
    public function show(Artistes $artiste): Response
    {
        return $this->render('artistes/show.html.twig', [
            'artiste' => $artiste,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="artistes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Artistes $artiste): Response
    {
        $form = $this->createForm(ArtistesType::class, $artiste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('artistes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('artistes/edit.html.twig', [
            'artiste' => $artiste,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="artistes_delete", methods={"POST"})
     */
    public function delete(Request $request, Artistes $artiste): Response
    {
        if ($this->isCsrfTokenValid('delete' . $artiste->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($artiste);
            $entityManager->flush();
        }

        return $this->redirectToRoute('artistes_index', [], Response::HTTP_SEE_OTHER);
    }
}
