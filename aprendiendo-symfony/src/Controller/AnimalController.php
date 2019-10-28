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
        $animal_repo = $this->getDoctrine()->getRepository(Animal::class);
        
        $animales = $animal_repo->findAll();
        
        //$animal = $animal_repo->findOneBy([
        $animal = $animal_repo->findBy([
            'raza' => 'mamifero'
        ],[
            'id' => 'DESC'
        ]);
        
        var_dump($animal);
        
        return $this->render('animal/index.html.twig', [
            'controller_name' => 'AnimalController',
            'animales' => $animales,
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
    
    public function animal(Animal $animal){
        
        /*
        //cargar el repositorio
        $animal_repo = $this->getDoctrine()->getRepository(Animal::class);
        
        //hacer la consulta
        $animal = $animal_repo->find($id);
        */
         //comprobar el resultado
        
        if(!$animal){
            $message = 'El animal no existe';
        }else{
            $message = 'Tu animal elegido es: ' . $animal->getTipo() . ' - '. $animal->getRaza();
        }
        
        return new Response($message);
    }
}
