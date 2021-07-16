<?php

namespace App\Controller;

use App\Entity\Conducteur;
use App\Form\ConducteurType;
use App\Repository\ConducteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/conducteur")
 */
class ConducteurController extends AbstractController {
    /**
     * @Route("/", name="conducteur_index", methods={"GET","POST"})
     */
    public function index(Request $request, ConducteurRepository $conducteurRepository): Response {
        $conducteur = new Conducteur();
        $form = $this->createForm(ConducteurType::class, $conducteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($conducteur);
            $entityManager->flush();

            return $this->redirectToRoute('conducteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('conducteur/index.html.twig', [
            'conducteurs' => $conducteurRepository->findAll(),
            'form' => $form->createView(),
            'conducteur' => $conducteur,
        ]);
    }

    /**
     * @Route("/new", name="conducteur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response {
        $conducteur = new Conducteur();
        $form = $this->createForm(ConducteurType::class, $conducteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($conducteur);
            $entityManager->flush();

            return $this->redirectToRoute('conducteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('conducteur/new.html.twig', [
            'conducteur' => $conducteur,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="conducteur_show", methods={"GET"})
     */
    public function show(Conducteur $conducteur): Response {
        return $this->render('conducteur/show.html.twig', [
            'conducteur' => $conducteur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="conducteur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Conducteur $conducteur): Response {
        $form = $this->createForm(ConducteurType::class, $conducteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('conducteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('conducteur/edit.html.twig', [
            'conducteur' => $conducteur,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="conducteur_delete", methods={"POST"})
     */
    public function delete(Request $request, Conducteur $conducteur): Response {
        if ($this->isCsrfTokenValid('delete' . $conducteur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($conducteur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('conducteur_index', [], Response::HTTP_SEE_OTHER);
    }
}
