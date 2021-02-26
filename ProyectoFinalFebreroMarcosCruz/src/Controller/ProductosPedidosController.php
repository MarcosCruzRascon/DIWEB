<?php

namespace App\Controller;

use App\Entity\Pedidos;
use App\Entity\ProductosPedidos;
use App\Form\ProductosPedidosType;
use App\Repository\ProductosPedidosRepository;
use App\Repository\ProductosRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @Route("/productos/pedidos")
 */
class ProductosPedidosController extends AbstractController
{
    /**
     * @Route("/", name="productos_pedidos_index", methods={"GET"})
     */
    public function index(ProductosPedidosRepository $productosPedidosRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        return $this->render('productos_pedidos/index.html.twig', [
            'productos_pedidos' => $productosPedidosRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="productos_pedidos_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        $productosPedido = new ProductosPedidos();
        $form = $this->createForm(ProductosPedidosType::class, $productosPedido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($productosPedido);
            $entityManager->flush();

            return $this->redirectToRoute('productos_pedidos_index');
        }

        return $this->render('productos_pedidos/new.html.twig', [
            'productos_pedido' => $productosPedido,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="productos_pedidos_show", methods={"GET"})
     */
    public function show(ProductosPedidos $productosPedido): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        return $this->render('productos_pedidos/show.html.twig', [
            'productos_pedido' => $productosPedido,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="productos_pedidos_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProductosPedidos $productosPedido): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        $form = $this->createForm(ProductosPedidosType::class, $productosPedido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('productos_pedidos_index');
        }

        return $this->render('productos_pedidos/edit.html.twig', [
            'productos_pedido' => $productosPedido,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="productos_pedidos_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ProductosPedidos $productosPedido): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        if ($this->isCsrfTokenValid('delete' . $productosPedido->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($productosPedido);
            $entityManager->flush();
        }

        return $this->redirectToRoute('productos_pedidos_index');
    }

    /**
     * @Route("/pagar", name="pagar", methods={"POST"})
     */
    public function pagar(ProductosRepository $productosRepository)
    {
        $productos = $_POST['productosCarrito'];
        $productos = array_count_values($productos);

        $pedido = new Pedidos();
        $fecha = new Date();
        $fecha = date("Y-m-d");
        $numero = rand(100, 100000);
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $pedido->setUsuario($user);
        $pedido->setIdpedido($fecha . $numero . $user->getId());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($pedido);

        foreach ($productos as $key => $value) {
            $productoPedido = new ProductosPedidos();
            $producto = $productosRepository->find($key);
            $productoPedido->setPedido($pedido);
            $productoPedido->setProducto($producto);
            $productoPedido->setCantidad($value);
            $entityManager->persist($productoPedido);
            $entityManager->flush();
        }

        $vars = array_keys(get_defined_vars());
        foreach ($vars as $var) {
            unset(${"$var"});
        }

        return $this->redirectToRoute('index');
    }
}
