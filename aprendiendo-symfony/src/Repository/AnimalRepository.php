<?php

namespace App\Repository;

use App\Entity\Animal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AnimalRepository extends ServiceEntityRepository{
    
    public function __construct(RegistryInterface $registry){
        parent::__construct($registry, Animal::class); 

    }
    
    public function getAnimalsOrderId($order){
        $query = $this->createQueryBuilder('a')
                             //->andWhere("a.raza = :raza")
                             //->setParameter('raza', 'mamifero')
                             ->orderBy('a.id', 'DESC')
                             ->getQuery();
        $resultset = $query->execute();
        
        return $resultset;
    }
    
    
    
}