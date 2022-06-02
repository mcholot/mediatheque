<?php

namespace App\Controller;

use App\Entity\Oeuvres;
use App\Entity\Artistes;
use App\Form\OeuvresType;
use App\Form\SearchOeuvreType;
use App\Repository\OeuvresRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/oeuvres")
 */
class OeuvresController extends AbstractController
{
    /**
     * @Route("/", name="oeuvres_index", methods={"GET","POST"})
     */
    public function index(OeuvresRepository $oeuvresRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $oeuvre = new Oeuvres();
        $artiste = new Artistes();
        $form = $this->createForm(SearchOeuvreType::class, $oeuvre);
        $form->handleRequest($request);
        $oeuvres = $oeuvresRepository->findOeuvres($oeuvre);


        $pagination = $paginator->paginate(
            $oeuvres,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('oeuvres/index.html.twig', [
            'form' => $form->createView(),
            'oeuvres' => $pagination
        ]);
    }

    /**
     * @Route("/new", name="oeuvres_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $oeuvre = new Oeuvres();
        $form = $this->createForm(OeuvresType::class, $oeuvre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($oeuvre);
            $entityManager->flush();

            return $this->redirectToRoute('oeuvres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('oeuvres/new.html.twig', [
            'oeuvre' => $oeuvre,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="oeuvres_show", methods={"GET"})
     */
    public function show(Oeuvres $oeuvre): Response
    {
        return $this->render('oeuvres/show.html.twig', [
            'oeuvre' => $oeuvre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="oeuvres_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Oeuvres $oeuvre): Response
    {
        $form = $this->createForm(OeuvresType::class, $oeuvre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('oeuvres_index', [], Response::HTTP_SEE_OTHER);
        }



        return $this->renderForm('oeuvres/edit.html.twig', [
            'oeuvre' => $oeuvre,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="oeuvres_delete", methods={"POST"})
     */
    public function delete(Request $request, Oeuvres $oeuvre): Response
    {
        if ($this->isCsrfTokenValid('delete' . $oeuvre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($oeuvre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('oeuvres_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/annule/{id}", name="oeuvres_annuler_reservation", methods={"GET","POST"})
     */
    public function annuler_reservation(Request $request, Oeuvres $oeuvre): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $oeuvre->setIdUser(0);
        $entityManager->persist($oeuvre);
        $entityManager->flush();

        return $this->redirectToRoute('oeuvres_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/oeuvres_reserver", name="oeuvres_reserver", methods={"GET","POST"})
     */
    public function oeuvres_reserver(Request $request, Oeuvres $oeuvre): Response
    {
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $oeuvre->setIdUser($user->getId());
        $entityManager->persist($oeuvre);
        $entityManager->flush();

        return $this->redirectToRoute('oeuvres_index', [], Response::HTTP_SEE_OTHER);
    }
}
