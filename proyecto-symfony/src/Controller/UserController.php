<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
USe Symfony\Component\HttpFoundation\Response;
USe Symfony\Component\HttpFoundation\Request;

use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder )
    {
        //creo formulario
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        
        //relleno objeto con datos del form
        $form->handleRequest($request);
        
        //compruebo si envia
        if($form->isSubmitted() && $form->isValid()){
            //modifico objeto
            $user->setRole('ROLE_USER');
        
            $user->setCreatedAt(new \DateTime('now'));
            //cifrar pass
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);
            
          //guardar usuario
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            return $this->redirectToRoute('tasks');
        }
        
        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    public function login(AuthenticationUtils $authenticationUtils){
        
        $error = $authenticationUtils->getLastAuthenticationError();
        
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render('user/login.html.twig',array(
            'error' => $error,
            'last_username' => $lastUsername
        ));
    }
}
