<?php

namespace App\Controller;

use App\Entity\Servicios;
use App\Form\ServiciosType;
use App\Repository\ServiciosRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/servicios")
 */
class ServiciosController extends AbstractController
{
    /**
     * @Route("/", name="servicios_index", methods={"GET"})
     */
    public function index(ServiciosRepository $serviciosRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');

        $query = $serviciosRepository->findAll();
       
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
        return $this->render('servicios/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @Route("/new", name="servicios_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        $servicio = new Servicios();
        $form = $this->createForm(ServiciosType::class, $servicio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($servicio);
            $entityManager->flush();

            return $this->redirectToRoute('servicios_index');
        }

        return $this->render('servicios/new.html.twig', [
            'servicio' => $servicio,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="servicios_show", methods={"GET"})
     */
    public function show(Servicios $servicio): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        return $this->render('servicios/show.html.twig', [
            'servicio' => $servicio,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="servicios_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Servicios $servicio): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        $form = $this->createForm(ServiciosType::class, $servicio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('servicios_index');
        }

        return $this->render('servicios/edit.html.twig', [
            'servicio' => $servicio,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="servicios_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Servicios $servicio): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        if ($this->isCsrfTokenValid('delete'.$servicio->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($servicio);
            $entityManager->flush();
        }

        return $this->redirectToRoute('servicios_index');
    }
}
