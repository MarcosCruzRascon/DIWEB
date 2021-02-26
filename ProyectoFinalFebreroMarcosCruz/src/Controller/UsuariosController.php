<?php

namespace App\Controller;

use App\Entity\Usuarios;
use App\Form\UsuariosType;
use App\Repository\ResetPasswordRequestRepository;
use App\Repository\UsuariosRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @Route("/usuarios")
 */

class UsuariosController extends AbstractController
{
    /**
     * @Route("/", name="usuarios_index", methods={"GET"})
     */
    public function index(UsuariosRepository $usuariosRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        $query = $usuariosRepository->findAll();
       
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
        return $this->render('usuarios/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @Route("/new", name="usuarios_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        return $this->redirectToRoute('app_register');
    }

    /**
     * @Route("/{id}", name="usuarios_show", methods={"GET"})
     */
    public function show(Usuarios $usuario): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        return $this->render('usuarios/show.html.twig', [
            'usuario' => $usuario,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="usuarios_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Usuarios $usuario, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        $form = $this->createForm(UsuariosType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imagen = $form->get('imagen')->getData();

            if ($imagen) {
                /*$originalFilename = pathinfo($imagen->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imagen->guessExtension();*/
                $fecha = new Date();
                $fecha = date("Y-m-d");
                $newFilename = $fecha . '-USER-' . $usuario->getId() . "." . $imagen->guessExtension();

                // Move the file to the directory where brochures are stored

                try {
                    $direccion = ($this->getParameter('brochures_directory')) . "/usuarios" . "/" . $usuario->getId() . "/";
                    $imagen->move(
                        $direccion,
                        $newFilename
                    );
                } catch (FileException $exception) {
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $usuario->setImagen($newFilename);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('usuarios_index');
        }

        return $this->render('usuarios/edit.html.twig', [
            'usuario' => $usuario,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="usuarios_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Usuarios $usuario, ResetPasswordRequestRepository $resetpassword): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'No se puede acceder a esta pagina!');
        if ($this->isCsrfTokenValid('delete' . $usuario->getId(), $request->request->get('_token'))) {
            $arrayPeticion=["user" => $usuario->getId()];
            $peticiones = $resetpassword->findBy($arrayPeticion);
            $entityManager = $this->getDoctrine()->getManager();
            foreach ($peticiones as $key) {
                $entityManager->remove($key);
            }
            $entityManager->remove($usuario);
            $entityManager->flush();
        }
        return $this->redirectToRoute('usuarios_index');
    }
}
