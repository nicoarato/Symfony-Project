<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Animal;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\Session;

use App\Form\AnimalType;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Email;



class AnimalController extends AbstractController
{
    public function validarEmail($email){
        
        $validator = Validation::createValidator();
        $errores = $validator->validate($email, [
                new Email()
        ]);
        
        if(count($errores) != 0){
            echo "El email es INCORRECTO. <br>";
            foreach ($errores as $error){
                echo $error->getMessage()."<br>";
            }
            
        }else{
            echo "El email está OK.";
        }
        die();
    }

    public function crearAnimal(Request $request){
        $animal = new Animal();
        $form = $this->createForm(AnimalType::class, $animal);
                     
        
        $form->handleRequest($request); //coloca en $animal los datos del form
        if($form->isSubmitted() && $form->isValid()){  //verifica si due enviado
            $em = $this->getDoctrine()->getManager();
            $em->persist($animal);
            $em->flush();
            
            //sesion
            $session = new Session();
            
            $session->getFlashBag()->add('message', 'Animal Creado');
            
            return $this->redirectToRoute('crear_animal');
            
        }
        
        
        return $this->render('animal/crear-animal.html.twig',[
            'form' => $form->createView()
        ]);
        
    }

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
        
        //var_dump($animal);
        
        //query builder
        $query = $animal_repo->createQueryBuilder('a')
                             //->andWhere("a.raza = :raza")
                             //->setParameter('raza', 'mamifero')
                             ->orderBy('a.id', 'DESC')
                             ->getQuery();
        $resultset = $query->execute();
        
        
        
        //DQL Doctrine Query Lenguage
        $em = $this->getDoctrine()->getManager();
        //$dql = "SELECT a FROM App\Entity\Animal a WHERE a.raza = 'mamifero'";
        $dql = "SELECT a FROM App\Entity\Animal a ORDER BY a.id DESC";
        
        $query_dql = $em->createQuery($dql);
        $resultset = $query_dql->execute();
        
        
        //SQL 
        
        $connection = $this->getDoctrine()->getConnection();
        $sql = 'SELECT * FROM animales ORDER BY id DESC';
        $prepare = $connection->prepare($sql);
        $prepare->execute();
        $resultset = $prepare->fetchAll();
        
        //var_dump($resultset);
        
        //Repository
        $animals = $animal_repo->getAnimalsOrderId('DESC');
        var_dump($animals);
        
        
        return $this->render('animal/index.html.twig', [
            'controller_name' => 'AnimalController',
            'animales' => $animales,
        ]);
    }
    
    public function save(Request $request){
        
        var_dump($request->get('form'));
        die();
        
        /*
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
         * 
         */
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
    
    public function update($id){
        //cargar doctrine
        $doctrine = $this->getDoctrine();
        //cargar entityManager
        $em = $doctrine->getManager();
        //cargar repo Animal
        $animal_repo = $em->getRepository(Animal::class);
        //find conseguir el objeto
        $animal = $animal_repo->find($id);
        //Comprobar si el objeto me llega
        if(!$animal){
            $message = 'El elemento no existe';
        }else{

        //Asignarle los valores al objeto
            $animal->setTipo("Perro $id");
            $animal->setColor('Rojo');
        //Persistir en doctrine
            $em->persist($animal);
        //Guardar en la bdatos
            $em->flush();
            $message = 'Se actualizó el animal' . $animal->getId();
        }
        //Respuesta
        return new Response($message);
    }
    
    public function delete(Animal $animal){
        //var_dump($animal);
        
        $em = $this->getDoctrine()->getManager();
        
        if($animal && is_object($animal)){
            $em->remove($animal);
            $em->flush();
            $message = 'Elemento borrado';
        }else{
            $message = 'No se pudo borrar el elemento';
        }
        return new Response($message);
    }
}
