<?php

namespace App\Repository\RGPD;

use App\Entity\RGPD\CGU;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CGU>
 *
 * @method CGU|null find($id, $lockMode = null, $lockVersion = null)
 * @method CGU|null findOneBy(array $criteria, array $orderBy = null)
 * @method CGU[]    findAll()
 * @method CGU[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CGURepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CGU::class);
    }

    public function add(CGU $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CGU $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findCurrentCGU()
    {
        return $this
            ->createQueryBuilder('p')
            ->where('p.implementationDate <= :now')
            ->andWhere('p.isDraft = FALSE')
            ->orderBy('p.implementationDate', 'DESC')
            ->setParameter('now', new DateTime('now'))
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return CGU[] Returns an array of CGU objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CGU
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
