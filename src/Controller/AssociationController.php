<?php

namespace App\Controller;

use App\Entity\Association;
use App\Form\AssociationType;
use App\Repository\AssociationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/association")
 */
class AssociationController extends AbstractController {
    /**
     * @Route("/", name="association_index", methods={"GET"})
     */
    public function index(Request $request, AssociationRepository $associationRepository): Response {
        $association = new Association();
        $form = $this->createForm(AssociationType::class, $association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($association);
            $entityManager->flush();

            return $this->redirectToRoute('association_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('association/index.html.twig', [
            'associations' => $associationRepository->findAll(),
            'form' => $form->createView(),
            'association' => $association,
        ]);
    }

    /**
     * @Route("/new", name="association_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response {
        $association = new Association();
        $form = $this->createForm(AssociationType::class, $association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($association);
            $entityManager->flush();

            return $this->redirectToRoute('association_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('association/new.html.twig', [
            'association' => $association,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="association_show", methods={"GET"})
     */
    public function show(Association $association): Response {
        return $this->render('association/show.html.twig', [
            'association' => $association,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="association_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Association $association): Response {
        $form = $this->createForm(AssociationType::class, $association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('association_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('association/edit.html.twig', [
            'association' => $association,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="association_delete", methods={"POST"})
     */
    public function delete(Request $request, Association $association): Response {
        if ($this->isCsrfTokenValid('delete' . $association->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($association);
            $entityManager->flush();
        }

        return $this->redirectToRoute('association_index', [], Response::HTTP_SEE_OTHER);
    }
}
