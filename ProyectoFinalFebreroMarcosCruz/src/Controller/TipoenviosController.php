<?php

namespace App\Controller;

use App\Entity\Tipoenvios;
use App\Form\TipoenviosType;
use App\Repository\TipoenviosRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tipoenvios")
 */
class TipoenviosController extends AbstractController
{
    /**
     * @Route("/", name="tipoenvios_index", methods={"GET"})
     */
    public function index(TipoenviosRepository $tipoenviosRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');

        $query = $tipoenviosRepository->findAll();
       
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
        return $this->render('tipoenvios/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @Route("/new", name="tipoenvios_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        $tipoenvio = new Tipoenvios();
        $form = $this->createForm(TipoenviosType::class, $tipoenvio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tipoenvio);
            $entityManager->flush();

            return $this->redirectToRoute('tipoenvios_index');
        }

        return $this->render('tipoenvios/new.html.twig', [
            'tipoenvio' => $tipoenvio,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tipoenvios_show", methods={"GET"})
     */
    public function show(Tipoenvios $tipoenvio): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        return $this->render('tipoenvios/show.html.twig', [
            'tipoenvio' => $tipoenvio,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tipoenvios_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tipoenvios $tipoenvio): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        $form = $this->createForm(TipoenviosType::class, $tipoenvio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tipoenvios_index');
        }

        return $this->render('tipoenvios/edit.html.twig', [
            'tipoenvio' => $tipoenvio,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tipoenvios_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Tipoenvios $tipoenvio): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        if ($this->isCsrfTokenValid('delete'.$tipoenvio->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tipoenvio);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tipoenvios_index');
    }
}
