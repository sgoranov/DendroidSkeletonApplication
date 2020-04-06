<?php
namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class UserRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, new ClassMetadata(User::class));
    }

    public function findByEmail(string $email)
    {
        $result = $this->createQueryBuilder('a')
            ->select()
            ->andWhere('a.email = :email')
            ->setParameter(':email', $email)
            ->getQuery()
            ->getResult();

        if (count($result) !== 1) {

            throw new EntityNotFoundException();
        }

        return $result[0];
    }

    public function findById(int $id): User
    {
        $list = $this->findBy(['id' => $id]);

        if (count($list) !== 1) {
            throw new EntityNotFoundException();
        }

        return $list[0];
    }
}