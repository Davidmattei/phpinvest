<?php

declare(strict_types=1);

namespace PhpInvest\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PhpInvest\Entity\GitRevision;
use PhpInvest\Invest\Git\Checkout;

final class GitRevisionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GitRevision::class);
    }

    public function findByCheckout(Checkout $checkout): ?GitRevision
    {
        $qb = $this->createQueryBuilder('gr');
        $revision = $qb
            ->andWhere($qb->expr()->eq('gr.branch', ':branch'))
            ->andWhere($qb->expr()->eq('gr.hash', ':hash'))
            ->setParameters(['branch' => $checkout->getBranch(), 'hash' => $checkout->getHash()])
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return $revision instanceof GitRevision ? $revision : null;
    }

    public function create(GitRevision $revision): void
    {
        $this->getEntityManager()->persist($revision);
        $this->getEntityManager()->flush();
    }
}
