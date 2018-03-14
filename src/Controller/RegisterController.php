<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends Controller
{

    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, Swift_Mailer $mailer)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            // Par defaut l'utilisateur aura toujours le rôle ROLE_USER
            $user->setRoles(['ROLE_USER']);

            // On enregistre l'utilisateur dans la base
            $gestionnaire = $this->getDoctrine()->getManager();
            $gestionnaire->persist($user);
            $gestionnaire->flush();

            //Envoi d'un mail de confirmation
            $email_user =$user->getEmail();
            $message = (new Swift_Message('Confirmation de votre inscription'))
                ->setFrom('simoncefimtest@gmail.com')
                ->setTo($email_user)
                ->setBody($this->renderView(
                'mail/confirm_registration.html.twig',
                array('name' => $user->getUsername())
            ), 'text/html', 'utf-8'
                );

            $mailer->send($message);

            //return $this->redirectToRoute('login');

            //Permet de tester si le mail part
            return new Response("<html><body></body></html>");
        }
        return $this->render(
            'register.html.twig',
            array('form' => $form->createView(), 'controller_name' => 'Register')
        );
    }
}
