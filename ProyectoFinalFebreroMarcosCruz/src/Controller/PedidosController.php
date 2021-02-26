<?php

namespace App\Controller;

use App\Entity\Pedidos;
use App\Form\PedidosType;
use App\Repository\PedidosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pedidos")
 */
class PedidosController extends AbstractController
{
    /**
     * @Route("/", name="pedidos_index", methods={"GET"})
     */
    public function index(PedidosRepository $pedidosRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        return $this->render('pedidos/index.html.twig', [
            'pedidos' => $pedidosRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="pedidos_new", methods={"GET","POST"})
     */
    /*public function new(Request $request): Response
    {
        $pedido = new Pedidos();
        $form = $this->createForm(PedidosType::class, $pedido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pedido);
            $entityManager->flush();

            return $this->redirectToRoute('pedidos_index');
        }

        return $this->render('pedidos/new.html.twig', [
            'pedido' => $pedido,
            'form' => $form->createView(),
        ]);
    }*/

    /**
     * @Route("/{id}", name="pedidos_show", methods={"GET"})
     */
    public function show(Pedidos $pedido): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        return $this->render('pedidos/show.html.twig', [
            'pedido' => $pedido,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="pedidos_edit", methods={"GET","POST"})
     */
    /*public function edit(Request $request, Pedidos $pedido): Response
    {
        $form = $this->createForm(PedidosType::class, $pedido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pedidos_index');
        }

        return $this->render('pedidos/edit.html.twig', [
            'pedido' => $pedido,
            'form' => $form->createView(),
        ]);
    }*/

    /**
     * @Route("/{id}", name="pedidos_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Pedidos $pedido): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        if ($this->isCsrfTokenValid('delete'.$pedido->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pedido);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pedidos_index');
    }
}
