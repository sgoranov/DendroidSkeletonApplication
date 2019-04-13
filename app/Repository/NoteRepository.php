<?php
namespace App\Repository;

use App\Entity\Note;
use App\Repository\DTO\Sort;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class NoteRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, new ClassMetadata(Note::class));
    }

    public function filter(Sort $sort = null, int $limit = null, int $offset = null)
    {
        $qb = $this->createQueryBuilder('a')
            ->select();

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
            ->select('COUNT(a.id) AS total');

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
        $list = $this->findBy(['id' => $id]);

        if (count($list) !== 1) {
            throw new EntityNotFoundException();
        }

        return $list[0];
    }
}