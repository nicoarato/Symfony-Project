<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'hello' => 'Hola Mundo con Symfony 4',
        ]);
    }
    
    public function animales($nombre, $apellido){
        $title = "Bienvenido a la pagina de animales";
        
        $animales = array('perro', 'gato', 'leon','paloma');
        $aves = array(
                    'tipo' => 'perico', 
                   'color' => 'gris', 
                    'edad' => 4,
                    'raza' => 'plumifero'
                    );
        
        
        return $this->render('home/animales.html.twig', [
            'title' => $title,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'animales' => $animales,
            'aves' => $aves
        ]);
    }
    
    public function redirigir(){
        //return $this->redirectToRoute('index');

        return $this->redirectToRoute('animales', [
            'nombre' => 'Juan cruz',
            'apellido' => 'Lopez'
        ]);
        
//        return $this->redirect('http://www.udemy.com');
    }
}
