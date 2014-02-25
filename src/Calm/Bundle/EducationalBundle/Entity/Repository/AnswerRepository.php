<?php

namespace Calm\Bundle\EducationalBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class AnswerRepository extends EntityRepository {

    public function getAnswersByQuestion($idQuestion) {

        $qb = $this
                ->createQueryBuilder('a')
                ->select('a, u')
                ->innerJoin('a.user', 'u')
                ->where('a.question = :idQuestion')
                ->andWhere('a.active = :status')
                ->setParameter('idQuestion', $idQuestion)
                ->setParameter('status', true)
                ->orderBy('a.timestamp', 'ASC');

        return $qb->getQuery()->getResult();
    }
   

}
