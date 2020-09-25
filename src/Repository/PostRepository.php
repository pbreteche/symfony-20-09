<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findLast()
    {
        return $this->getEntityManager()->createQuery(
            'SELECT p FROM '.Post::class.' p WHERE p.publishedAt < CURRENT_DATE() ORDER BY p.publishedAt DESC'
        )->setMaxResults(10)
            ->getResult();
    }

    public function findWithAuthor(int $id)
    {
        return $this->createQueryBuilder('p')
            ->join('p.writtenBy', 'a')
            ->addSelect('a')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByPostSameAuthor(Post $post)
    {
        $qb = $this->createQueryBuilder('p');

        return $qb
            ->andWhere('p.writtenBy = :author')
            ->andWhere($qb->expr()->neq('p.id', ':id'))
            ->getQuery()
            ->setParameters([
                'author' => $post->getWrittenBy(),
                'id' => $post->getId(),
            ])
            ->getResult();
    }
}
