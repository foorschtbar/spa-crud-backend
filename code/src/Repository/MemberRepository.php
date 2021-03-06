<?php

namespace App\Repository;

use App\Entity\Member;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Member|null find($id, $lockMode = null, $lockVersion = null)
 * @method Member|null findOneBy(array $criteria, array $orderBy = null)
 * @method Member[]    findAll()
 * @method Member[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Member::class);
    }

    public function transform(Member $member)
    {
        return [
            'id'    => (int) $member->getId(),
            'firstname' => (string) $member->getFirstname(),
            'lastname' => (string) $member->getLastname(),
            'phone' => (string) $member->getPhone(),
            'email' => (string) $member->getEmail(),
            'city' => (string) $member->getCity(),
            'street' => (string) $member->getStreet(),
            'birthday' => (string) $member->getBirthday()->format('Y-m-d')
        ];
    }

    public function transformArray(Array $members) {
        $allmembers = [];

        foreach ($members as $member) {
            $allmembers[] = $this->transform($member);
        }

        return $allmembers;
    }

    public function transformAll()
    {
        $members = $this->findAll();
        return $this->transformArray($members);
    }

    public function transformSearch($field, $value) {
        $members = $this->findByField($field, $value);
        return $this->transformArray($members);
    }

    public function findByField($field, $value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.'.$field.' LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        ;
    }

    /*
    public function findOneBySomeField($value): ?Member
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
