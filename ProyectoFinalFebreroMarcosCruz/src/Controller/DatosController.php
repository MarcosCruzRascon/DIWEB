<?php

namespace App\Controller;

use App\Entity\Pedidos;
use App\Entity\ProductosPedidos;
use App\Repository\ProductosPedidosRepository;
use App\Repository\ProductosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class DatosController extends AbstractController
{
    /**
     * @Route("/catalogo", name="catalogojson", methods={"GET"})
     */
    public function getAllCategoryAction(ProductosRepository $productosRepository): JsonResponse
    {
        $producto = $productosRepository->findAll();
        return new JsonResponse($producto);
    }

    /**
     * @Route("/catalogo/{id}", name="productojson", methods={"GET"})
     */
    public function producto(ProductosRepository $productosRepository, $id): JsonResponse
    {
        $producto = $productosRepository->find($id);
        return new JsonResponse($producto);
    }

}
