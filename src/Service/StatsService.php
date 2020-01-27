<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class StatsService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getStats()
    {
        $users = $this->getUsersCount();
        $ads = $this->getAdsCount();
        $bookings = $this->getBookingsCount();
        $comments = $this->getCommentsCount();

        return compact('users', 'ads', 'bookings', 'comments');
    }

    public function getUsersCount()
    {
        return $this->em->createQuery('SELECT count(u) FROM App\Entity\User u')->getSingleScalarResult();
    }

    public function getAdsCount()
    {
        return $this->em->createQuery('SELECT count(a) FROM App\Entity\Ad a')->getSingleScalarResult();
    }

    public function getBookingsCount()
    {
        return $this->em->createQuery('SELECT count(b) FROM App\Entity\Booking b')->getSingleScalarResult();
    }

    public function getCommentsCount()
    {
        return $this->em->createQuery('SELECT count(c) FROM App\Entity\Comment c')->getSingleScalarResult();
    }

    public function getAdsStats($direction)
    {
        return $this->em->createQuery(
            'SELECT AVG(c.rating) as note, a.title, a.id, u.firstName, u.lastName, u.picture
            FROM App\Entity\Comment c
            JOIN c.ad a
            JOIN c.author u
            GROUP BY a
            ORDER BY note ' . $direction
        )
            ->setMaxResults(5)
            ->getResult();
    }

    // public function getBestAds()
    // {
    //     return $this->em->createQuery(
    //         'SELECT AVG(c.rating) as note, a.title, a.id, u.firstName, u.lastName, u.picture
    //         FROM App\Entity\Comment c
    //         JOIN c.ad a
    //         JOIN c.author u
    //         GROUP BY a
    //         ORDER BY note DESC
    //         '
    //     )
    //         ->setMaxResults(5)
    //         ->getResult();
    // }

    // public function getWorstAds()
    // {
    //     return $this->em->createQuery(
    //         'SELECT AVG(c.rating) as note, a.title, a.id, u.firstName, u.lastName, u.picture
    //         FROM App\Entity\Comment c
    //         JOIN c.ad a
    //         JOIN c.author u
    //         GROUP BY a
    //         ORDER BY note ASC
    //         '
    //     )
    //         ->setMaxResults(5)
    //         ->getResult();
    // }
}
