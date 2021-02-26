<?php

namespace App\Controller;

use App\Entity\Visitas;
use App\Form\VisitasType;
use App\Repository\VisitasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/visitas")
 */
class VisitasController extends AbstractController
{
    /**
     * @Route("/", name="visitas_index", methods={"GET"})
     */
    public function index(VisitasRepository $visitasRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        return $this->render('visitas/index.html.twig', [
            'visitas' => $visitasRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{agenda}", name="visitas_agenda", methods={"GET"})
     */
    public function visitasUsuario(VisitasRepository $visitasRepository, $agenda): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        return $this->render('visitas/index.html.twig', [
            'visitas' => $visitasRepository->findByAgenda($agenda),
        ]);
    }

    /**
     * @Route("/new", name="visitas_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        $visita = new Visitas();
        $form = $this->createForm(VisitasType::class, $visita);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($visita);
            $entityManager->flush();

            return $this->redirectToRoute('visitas_index');
        }

        return $this->render('visitas/new.html.twig', [
            'visita' => $visita,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="visitas_show", methods={"GET"})
     */
    public function show(Visitas $visita): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        return $this->render('visitas/show.html.twig', [
            'visita' => $visita,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="visitas_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Visitas $visita): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        $form = $this->createForm(VisitasType::class, $visita);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('visitas_index');
        }

        return $this->render('visitas/edit.html.twig', [
            'visita' => $visita,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="visitas_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Visitas $visita): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        if ($this->isCsrfTokenValid('delete'.$visita->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($visita);
            $entityManager->flush();
        }

        return $this->redirectToRoute('visitas_index');
    }
}
