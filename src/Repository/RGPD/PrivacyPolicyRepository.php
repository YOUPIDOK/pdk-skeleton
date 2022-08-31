<?php

namespace App\Repository\RGPD;

use App\Entity\RGPD\PrivacyPolicy;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PrivacyPolicy>
 *
 * @method PrivacyPolicy|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrivacyPolicy|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrivacyPolicy[]    findAll()
 * @method PrivacyPolicy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrivacyPolicyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PrivacyPolicy::class);
    }

    public function add(PrivacyPolicy $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PrivacyPolicy $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findCurrentPrivacyPolicy()
    {
       return $this
           ->createQueryBuilder('p')
           ->where('p.implementationDate <= :now')
           ->orderBy('p.implementationDate', 'DESC')
           ->setParameter('now', new DateTime('now'))
           ->setMaxResults(1)
           ->getQuery()
           ->getOneOrNullResult();
    }

}
