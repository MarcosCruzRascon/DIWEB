<?php

namespace App\Controller;

use App\Entity\Agenda;
use App\Entity\Usuarios;
use App\Form\RegistrationFormType;
use App\Repository\UsuariosRepository;
use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Validator\Constraints\Date;

class RegistrationController extends AbstractController
{
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new Usuarios();
        $agenda = new Agenda();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted()) {
            $dni = $form->get('dni_nif')->getData();
            $validacion = $this->validacionDNI($dni);
            if (!$validacion) {
                $validacion = $this->validacionNIF($dni);
            }

            if (!$validacion) {
                $form->addError(new FormError('El dni/nif no es valido'));
            }
        }
        
        if ($form->isSubmitted() && $form->isValid() && $validacion) {
            // encode the plain password
            $imagen = $form->get('imagen')->getData();

            if ($imagen) {
                /*$originalFilename = pathinfo($imagen->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imagen->guessExtension();*/
                $fecha = new Date();
                $fecha = date("Y-m-d");
                $newFilename = $fecha . '-USER-' . $user->getId() . "." . $imagen->guessExtension();

                // Move the file to the directory where brochures are stored

                try {
                    $direccion = ($this->getParameter('brochures_directory')) . "/usuarios" . "/" . $user->getId() . "/";
                    $imagen->move(
                        $direccion,
                        $newFilename
                    );
                } catch (FileException $exception) {
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setImagen($newFilename);
            }
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $agenda->setUsuario($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->persist($agenda);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation(
                'app_verify_email',
                $user,
                (new TemplatedEmail())
                    ->from(new Address('2daamcruras31@ieslasfuentezuelas.com', 'Marcos Cruz'))
                    ->to($user->getCorreo())
                    ->subject('Verifique su correo electronico')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

            return $this->redirectToRoute('index');
        }

        return $this->render('registration/register.html.twig', [
            'usuario' => $user,
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request): Response
    {

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Tu email se ha verificado.');

        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/verify/resend//{id}", name="app_resend", methods={"GET","POST"})
     */
    public function resend($id, UsuariosRepository $usuariosRepository)
    {
        $user = $usuariosRepository->find($id);
        $this->emailVerifier->sendEmailConfirmation(
            'app_verify_email',
            $user,
            (new TemplatedEmail())
                ->from(new Address('2daamcruras31@ieslasfuentezuelas.com', 'Marcos Cruz'))
                ->to($user->getCorreo())
                ->subject('Verifique su correo electronico')
                ->htmlTemplate('registration/confirmation_email.html.twig')
        );


        return $this->redirectToRoute('usuarios_edit', array(
            'id' => $id,
        ));
    }

    public function validacionDNI($campo)
    {
        $letras = "TRWAGMYFPDXBNJZSQVHLCKE";
        $mensaje = "";
        if (preg_match("/^[0-9]{8}[a-zA-z]{1}$/", $campo) == 1) {
            $numero = substr($campo, 0, 8);
            $letra = substr($campo, 8, 1);
            if ($letras[$numero % 23] == strtoupper($letra)) {
                return TRUE;
            } else {
                $mensaje = "El campo $campo es un Dni con letra no válida";
            }
        } else {
            $mensaje = "El campo $campo no es un Dni válido";
        }
        $this->errores[$campo] = $mensaje;
        return FALSE;
    }

    function validacionNIF($nif)
    {
        $nif = strtoupper(str_replace("-", "", trim($nif)));

        if (preg_match("/^[ABCDEFGHJNPQRSUVW]{1}[0-9]{7}[0-9A-Z]{1}/", $nif)) {
            $nif_codes = 'JABCDEFGHI';
            $sum = (string) $this->getNifSum($nif);
            $n = (10 - substr($sum, -1)) % 10;

            if (strpos('ABCDEFGHJUV', $nif[0]) !== FALSE) {
                // Numerico
                return ($nif[8] == $n);
            } else if (strpos('PQRSNW', $nif[0]) !== FALSE) {
                // Letras
                return ($nif[8] == $nif_codes[$n]);
            }
        }

        return FALSE;
    }

    // Función auxiliar usada para CIFs y NIFs especiales
    function getNifSum($nif)
    {
        $sum = $nif[2] + $nif[4] + $nif[6];

        for ($i = 1; $i < 8; $i += 2) {
            $tmp = (string) (2 * $nif[$i]);

            $tmp = $tmp[0] + ((strlen($tmp) > 1) ? $tmp[1] : 0);

            $sum += $tmp;
        }

        return $sum;
    }
}
