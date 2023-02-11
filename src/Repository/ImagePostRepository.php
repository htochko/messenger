<?php

namespace App\Repository;

use App\Entity\ImagePost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ImagePost>
 *
 * @method ImagePost|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImagePost|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImagePost[]    findAll()
 * @method ImagePost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImagePostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImagePost::class);
    }

    public function save(ImagePost $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ImagePost $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
