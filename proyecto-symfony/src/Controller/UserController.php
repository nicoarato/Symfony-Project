<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
USe Symfony\Component\HttpFoundation\Response;
USe Symfony\Component\HttpFoundation\Request;

use App\Entity\User;
use App\Form\RegisterType;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function register(Request $request)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        
        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
