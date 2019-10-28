<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Animal;

class AnimalController extends AbstractController
{

    public function index()
    {
        return $this->render('animal/index.html.twig', [
            'controller_name' => 'AnimalController',
        ]);
    }
    
    public function save(){
        //guardar en una tabla de la bdatos
        
        //cargo el manager
        $entityManager = $this->getDoctrine()->getManager(); 
        
        //creo el objeto y cargo valores
        $animal = new Animal();
        $animal->setTipo('avestruz');
        $animal->setColor('gris');
        $animal->setRaza('Plumifero');
        
        //Persistir
        $entityManager->persist($animal);
        
        //sincronizar
        $entityManager->flush();
        
        return new Response('El Animal guardado tiene el id ' . $animal->getId());
    }
}
