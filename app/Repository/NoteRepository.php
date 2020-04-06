<?php
namespace App\Repository;

use App\Entity\Note;
use App\Entity\User;
use App\Repository\DTO\Sort;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class NoteRepository extends EntityRepository
{
    protected User $user;

    public function __construct(EntityManagerInterface $em, User $user)
    {
        parent::__construct($em, new ClassMetadata(Note::class));

        $this->user = $user;
    }

    public function filter(Sort $sort = null, int $limit = null, int $offset = null)
    {
        $qb = $this->createQueryBuilder('a')
            ->select()
            ->andWhere('a.user = :user')
            ->setParameter(':user', $this->user);

        if (!is_null($sort)) {
            switch ($sort->getField()) {
                case 'title':
                    $field = 'a.title';
                    break;

                default:
                    $field = 'a.id';
                    break;
            }

            $qb->orderBy($field, $sort->getType());
        }

        $query = $qb->getQuery();

        if ($limit) {
            $query->setMaxResults($limit);
        }

        if ($offset) {
            $query->setFirstResult($offset);
        }

        return $query->getResult();
    }

    public function getTotal()
    {
        $qb = $this->createQueryBuilder('a')
            ->select('COUNT(a.id) AS total')
            ->andWhere('a.user = :user')
            ->setParameter(':user', $this->user);

        $result = $qb->getQuery()->getSingleResult();

        return $result['total'];
    }

    public function delete($id)
    {
        $transaction = $this->findById($id);

        $entityManager = $this->getEntityManager();
        $entityManager->remove($transaction);
        $entityManager->flush();
    }

    public function findById(int $id): Note
    {
        $list = $this->findBy(['id' => $id, 'user' => $this->user]);

        if (count($list) !== 1) {
            throw new EntityNotFoundException();
        }

        return $list[0];
    }
}