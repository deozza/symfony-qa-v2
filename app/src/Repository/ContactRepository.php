<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contact>
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

       /**
        * @return Contact[] Returns an array of Contact objects
        */
       public function findByExampleField($value): array
       {
           return $this->createQueryBuilder('c')
               ->andWhere('c.exampleField = :val')
               ->setParameter('val', $value)
               ->orderBy('c.id', 'ASC')
               ->setMaxResults(10)
               ->getQuery()
               ->getResult()
           ;

         }


         public function findEmptyMessageFromGmailAddresses(): array {
             return $this->createQueryBuilder('c')
                 ->select('c.id')
                 ->andWhere('c.sender LIKE :email')
                 ->andWhere('c.message = :message')
                 ->setParameters([
                     'email' => '%gmail.com',
                     'message' => ''
                 ])
                 ->getQuery()
                 ->getResult();
         }


         // récupérer les ID de tous les contacts dont l'addresse de sender finit par `gmail.com` et dont le message est vide

    //    public function findOneBySomeField($value): ?Contact
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
