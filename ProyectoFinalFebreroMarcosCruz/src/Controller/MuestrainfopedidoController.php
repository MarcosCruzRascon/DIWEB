<?php

namespace App\Controller;


use App\Repository\PedidosRepository;
use App\Repository\ProductosPedidosRepository;
use App\Repository\ProductosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MuestrainfopedidoController extends AbstractController
{
    /**
     * @Route("/muestrainfopedido/{id}", name="muestrainfopedido")
     */
    public function index($id, ProductosPedidosRepository $productosPedidosRepository, ProductosRepository $productosrepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        $listadoproductos = [];
        $arrayBusqueda=["pedido"=>$id];
        $productos = $productosPedidosRepository->findBy($arrayBusqueda);
        
        for ($i=0; $i < count($productos); $i++) { 
           array_push($listadoproductos, ["producto" =>$productos[$i]->getProducto(), "cantidad" => $productos[$i]->getCantidad()]);
        }

        return $this->render('muestrainfopedido/index.html.twig', ['listaproductos'=> $listadoproductos]);
    }
}
